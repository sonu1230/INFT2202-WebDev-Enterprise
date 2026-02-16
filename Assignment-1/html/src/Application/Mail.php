<?php
namespace Application;

use PDO;

class Mail {
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createMail($subject, $body) {
        $stmt = $this->pdo->prepare("INSERT INTO mail (subject, body) VALUES (?, ?) RETURNING id");
        $stmt->execute([$subject, $body]);

        return $stmt->fetchColumn();
    }
    public function getAll(): array
    {
        // Fetch records by id
        $stmt = $this->pdo->query(
            "SELECT id, subject, body FROM mail ORDER BY id ASC"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array
    {
        // query with id
        $stmt = $this->pdo->prepare(
            "SELECT id, subject, body FROM mail WHERE id = :id"
        );

        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return null if record not exists
        return $row ? $row : null;
    }

    public function deleteById(int $id): bool
    {
        // execute delete query
        $stmt = $this->pdo->prepare(
            "DELETE FROM mail WHERE id = :id"
        );

        $stmt->execute([':id' => $id]);

        // Checking if one row is delete or not
        return $stmt->rowCount() === 1;
    }
}
}