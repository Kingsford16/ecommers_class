<?php

require_once __DIR__ . '/../core/db_class.php';

// CustomerClass handles customer-related database operations
class CustomerClass extends Database
{
    // Check if the email already exists in the database
    public function emailExists($email)
    {
        $stmt = $this->conn->prepare(
            'SELECT customer_email
             FROM customer
             WHERE customer_email = ?'
        );

        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;

        $stmt->close();

        return $exists;
    }
    // Add a new customer to the database
    public function addCustomer(
        $name,
        $email,
        $pass,
        $country,
        $city,
        $contact
    ) {
        // Hash the password before storing it
        $hashedPassword = password_hash($pass, PASSWORD_BCRYPT);

        $stmt = $this->conn->prepare(
            'INSERT INTO customer
            (
                customer_name,
                customer_email,
                customer_pass,
                customer_country,
                customer_city,
                customer_contact
            )
            VALUES (?, ?, ?, ?, ?, ?)'
        );

        $stmt->bind_param(
            'ssssss',
            $name,
            $email,
            $hashedPassword,
            $country,
            $city,
            $contact
        );

        $success = $stmt->execute();

        // Get the ID of the newly created customer
        $newCustomerId = $this->conn->insert_id;

        $stmt->close();

        if ($success) {
            return $newCustomerId;
        }

        return false;
    }

    // Retrieve customer details by email
public function getCustomerByEmail($email)
{
    $stmt = $this->conn->prepare(
        "SELECT * FROM customer WHERE customer_email = ?"
    );

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();

    $stmt->close();

    return $customer ?: false;
}

// Verify customer login credentials
public function login($email, $pass)
{
    $customer = $this->getCustomerByEmail($email);

    if ($customer && password_verify($pass, $customer['customer_pass'])) {
        return $customer;
    }

    return false;
}
}
