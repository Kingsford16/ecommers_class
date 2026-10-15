
<?php

require_once __DIR__ . '/../core/db_class.php';

class CartClass extends Database
{
    // Check whether this product is already in this visitor's cart.
    public function isInCart($product_id, $ip)
    {
        $stmt = $this->conn->prepare(
            "SELECT p_id FROM cart WHERE p_id = ? AND ip_add = ?"
        );

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("is", $product_id, $ip);
        $stmt->execute();

        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;

        $stmt->close();

        return $exists;
    }

    // Add a product to the cart.
    public function addToCart($product_id, $qty, $ip, $customer_id = null)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO cart (p_id, ip_add, qty) VALUES (?, ?, ?)"
        );

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("isi", $product_id, $ip, $qty);
        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }

    // Get cart items together with their product details.
    public function getCartItems($ip)
    {
        $stmt = $this->conn->prepare(
            "SELECT cart.*,
                    products.product_title,
                    products.product_price,
                    products.product_image
             FROM cart
             JOIN products ON cart.p_id = products.product_id
             WHERE cart.ip_add = ?"
        );

        if (!$stmt) {
            return [];
        }

        $stmt->bind_param("s", $ip);

        if (!$stmt->execute()) {
            $stmt->close();
            return [];
        }

        $result = $stmt->get_result();
        $items = $result
            ? $result->fetch_all(MYSQLI_ASSOC)
            : [];

        $stmt->close();

        return $items;
    }

    // Count the number of cart rows for this visitor.
    public function getCartCount($ip)
    {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) AS cart_count FROM cart WHERE ip_add = ?"
        );

        if (!$stmt) {
            return 0;
        }

        $stmt->bind_param("s", $ip);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        return (int) ($row['cart_count'] ?? 0);
    }

    // Calculate the total price of all items in the cart.
    public function getCartTotal($ip)
    {
        $items = $this->getCartItems($ip);
        $total = 0.0;

        foreach ($items as $item) {
            $total += (int) $item['qty']
                * (float) $item['product_price'];
        }

        return $total;
    }

    // Remove a product from this visitor's cart.
    public function removeFromCart($product_id, $ip)
    {
        $stmt = $this->conn->prepare(
            "DELETE FROM cart WHERE p_id = ? AND ip_add = ?"
        );

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("is", $product_id, $ip);
        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }

    // Update a product's quantity, allowing only quantities of 1 or more.
    public function updateQty($product_id, $new_qty, $ip)
    {
        $product_id = filter_var($product_id, FILTER_VALIDATE_INT);
        $new_qty = filter_var($new_qty, FILTER_VALIDATE_INT);

        if (
            $product_id === false || $product_id < 1 ||
            $new_qty === false || $new_qty < 1
        ) {
            return false;
        }

        $stmt = $this->conn->prepare(
            "UPDATE cart
             SET qty = ?
             WHERE p_id = ? AND ip_add = ?"
        );

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("iis", $new_qty, $product_id, $ip);
        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }
}
