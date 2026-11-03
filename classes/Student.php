
<?php

class Student
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Get all studente (never return passwords)
    public function getAll(): array
    {
        $sql = "SELECT id, name, email, course, created_at
                FROM student
                ORDER BY id DESC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    // Get student by ID (never return password)
    public function getById(int $id): ?array
    {
        $sql = "SELECT id, name, email, course, created_at
                FROM student
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        $student = $stmt->fetch();

        return $student ?: null;
    }

    // Create student
    public function create(
        string $name,
        string $email,
        string $course,
        string $password
    ): int {
        // Hash password before saving
        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $sql = "INSERT INTO student
                (name, email, course, password)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            $name,
            $email,
            $course,
            $hashedPassword
        ]);

        return (int) $this->db->lastInsertId();
    }

    // Update student
    // Password is optional when updating
    public function update(
        int $id,
        string $name,
        string $email,
        string $course,
        ?string $password = null
    ): bool {
        if ($password !== null && $password !== "") {
            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $sql = "UPDATE student
                    SET name = ?,
                        email = ?,
                        course = ?,
                        password = ?
                    WHERE id = ?";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                $name,
                $email,
                $course,
                $hashedPassword,
                $id
            ]);
        } else {
            $sql = "UPDATE student
                    SET name = ?,
                        email = ?,
                        course = ?
                    WHERE id = ?";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                $name,
                $email,
                $course,
                $id
            ]);
        }

        return $stmt->rowCount() > 0;
    }

    // Verify password (for future login functionality)
    public function verifyPassword(
        int $id,
        string $password
    ): bool {
        $sql = "SELECT password
                FROM student
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        $student = $stmt->fetch();

        if (!$student) {
            return false;
        }

        return password_verify(
            $password,
            $student["password"]
        );
    }

    // Delete student
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM student WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
    }
}
