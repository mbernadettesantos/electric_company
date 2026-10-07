<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CustomerAccountModel;

class AccountManagement extends BaseController
{
    private function requireLogin()
    {
        return session()->get('isLogged') === true ? null : redirect()->to(base_url('login'));
    }

    public function login()
    {
        if (session()->get('isLogged') === true) {
            return redirect()->to(base_url('dashboard'));
        }

        if ($this->request->getMethod() === 'POST') {
            if (! $this->validate([
                'username' => 'required|max_length[100]',
                'password' => 'required|max_length[255]',
            ])) {
                return redirect()->back()->withInput()->with('error', 'Enter both your username and password.');
            }

            $username = (string) $this->request->getPost('username');
            $password = (string) $this->request->getPost('password');
            $user = (new UserModel())->where('username', $username)->first();

            $valid = $user && (
                password_verify($password, (string) $user['password'])
                || hash_equals((string) $user['password'], $password)
            );

            if (! $valid) {
                return redirect()->back()->withInput()->with('error', 'Invalid username or password.');
            }

            session()->regenerate();
            session()->set([
                'isLogged' => true,
                'user_id' => $user['id'],
                'username' => $user['username'],
            ]);

            return redirect()->to(base_url('dashboard'));
        }

        return view('login', ['title' => 'Login - Puihaha Electric']);
    }

    public function dashboard()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $model = new CustomerAccountModel();
        $keyword = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        $type = $this->request->getGet('type');
        $perPage = 10;

        if ($keyword) {
            $accounts = $model->searchAccounts($keyword, $perPage);
        } elseif ($status) {
            $accounts = $model->getAccountsByStatus($status, $perPage);
        } elseif ($type) {
            $accounts = $model->getAccountsByType($type, $perPage);
        } else {
            $accounts = $model->getAccountsPaginated($perPage);
        }

        return view('dashboard', [
            'title' => 'Customer Accounts - Puihaha Electric',
            'page' => 'dashboard',
            'username' => session()->get('username'),
            'accounts' => $accounts,
            'pager' => $model->pager,
            'total_accounts' => $model->getTotalAccounts(),
            'active_accounts' => $model->getCountByStatus('active'),
            'inactive_accounts' => $model->getCountByStatus('inactive'),
            'suspended_accounts' => $model->getCountByStatus('suspended'),
            'current_page' => $this->request->getGet('page') ?? 1,
            'search_keyword' => $keyword,
            'filter_status' => $status,
            'filter_type' => $type,
        ]);
    }

    public function viewAccount($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $account = (new CustomerAccountModel())->find($id);

        if (! $account) {
            return redirect()->to(base_url('dashboard'))->with('error', 'Account not found.');
        }

        return view('view_account', [
            'title' => 'Account Details - Puihaha Electric',
            'page' => 'dashboard',
            'account' => $account,
        ]);
    }

    public function createAccount()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        return view('account_form', [
            'title' => 'Add Customer Account',
            'page' => 'dashboard',
            'account' => null,
            'action' => base_url('account/create'),
        ]);
    }

    public function storeAccount()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $rules = [
            'account_number' => 'required|max_length[50]|is_unique[customer_accounts.account_number]',
            'customer_name' => 'required|max_length[150]',
            'email' => 'permit_empty|valid_email|max_length[150]',
            'connection_type' => 'required|in_list[residential,commercial,industrial]',
            'status' => 'required|in_list[active,inactive,suspended]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new CustomerAccountModel())->insert($this->accountData());

        return redirect()->to(base_url('dashboard'))->with('success', 'Customer account added successfully.');
    }

    public function editAccount($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $account = (new CustomerAccountModel())->find($id);

        if (! $account) {
            return redirect()->to(base_url('dashboard'))->with('error', 'Account not found.');
        }

        return view('account_form', [
            'title' => 'Edit Customer Account',
            'page' => 'dashboard',
            'account' => $account,
            'action' => base_url('account/' . $id . '/edit'),
        ]);
    }

    public function updateAccount($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $model = new CustomerAccountModel();
        $account = $model->find($id);

        if (! $account) {
            return redirect()->to(base_url('dashboard'))->with('error', 'Account not found.');
        }

        $rules = [
            'account_number' => "required|max_length[50]|is_unique[customer_accounts.account_number,id,{$id}]",
            'customer_name' => 'required|max_length[150]',
            'email' => 'permit_empty|valid_email|max_length[150]',
            'connection_type' => 'required|in_list[residential,commercial,industrial]',
            'status' => 'required|in_list[active,inactive,suspended]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, $this->accountData());

        return redirect()->to(base_url('dashboard'))->with('success', 'Customer account updated successfully.');
    }

    public function deleteAccount($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $model = new CustomerAccountModel();

        if (! $model->find($id)) {
            return redirect()->to(base_url('dashboard'))->with('error', 'Account not found.');
        }

        $model->delete($id);

        return redirect()->to(base_url('dashboard'))->with('success', 'Customer account deleted.');
    }

    private function accountData(): array
    {
        return [
            'account_number' => $this->request->getPost('account_number'),
            'customer_name' => $this->request->getPost('customer_name'),
            'address' => $this->request->getPost('address'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'meter_number' => $this->request->getPost('meter_number'),
            'connection_type' => $this->request->getPost('connection_type'),
            'status' => $this->request->getPost('status'),
        ];
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('login'))->with('success', 'You have been logged out.');
    }
}
