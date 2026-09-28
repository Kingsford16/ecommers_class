<?php

require_once __DIR__ . '/../classes/CustomerClass.php';

class CustomerController
{
    private $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerClass();
    }

    // Register a new customer
public function register($data)
{
    // Check whether the email is already registered
    if ($this->customerModel->emailExists($data['email'])) {
        return [
            'success' => false,
            'error' => 'Email already registered.'
        ];
    }

    // Create the customer
    $created = $this->customerModel->addCustomer(
        $data['name'],
        $data['email'],
        $data['pass'],
        $data['country'],
        $data['city'],
        $data['contact']
    );

    // Check if the customer was created successfully
    if ($created) {
        return [
            'success' => true,
            'customer_id' => $created
        ];
    }

    return [
        'success' => false,
        'error' => 'Registration failed. Please try again.'
    ];
}

    // Handle customer login
    public function login($email, $pass)
    {
        $customer = $this->customerModel->login($email, $pass);

        if ($customer) {
            return $customer;
        }

        return [
            'success' => false,
            'error' => 'Invalid email or password.'
        ];
    }
}