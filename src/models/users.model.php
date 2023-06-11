<?php

enum Origin: string
{
    case LOCAL = "LOCAL";
    case EXTERNAL = "EXTERNAL";
}

enum UserType: string
{
    case CANDIDATE = "CANDIDATE";
    case COMPANY = "COMPANY";
}

class Candidate
{
    public $id;
    public $firstName;
    public $lastName;
    public $userId;

    public function __construct(int $id, string $firstName, string $lastName, int $userId)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->userId = $userId;
    }
}

class Company
{
    public $id;
    public $name;
    public $location;
    public $description;
    public $userId;

    public function __construct(int $id, string $name, string $location, string $description, int $userId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->location = $location;
        $this->description = $description;
        $this->userId = $userId;
    }
}

class User
{
    public $id;
    public $email;
    public $password;
    public $origin;
    public $createdAt;
    public $updatedAt;
    public $userType;

    public function __construct(int $id, string $email, string $password, string $origin, string $userType)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->origin = $origin;
        $this->userType = $userType;
    }
}

class UsersModel
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $query = $this->db->prepare('SELECT * FROM User');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($result as $user) {
            $users[] = new User(
                $user['id'],
                $user['email'],
                $user['password'],
                $user['origin'],
                $user['userType']
            );
        }

        return $users;
    }

    public function getOne(int $id): User
    {
        $query = $this->db->prepare('SELECT * FROM User WHERE id = :id');
        $query->execute(['id' => $id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        return new User(
            $result['id'],
            $result['email'],
            $result['password'],
            $result['origin'],
            $result['userType']
        );
    }

    public function getByEmail(string $email): User
    {
        $query = $this->db->prepare('SELECT * FROM User WHERE email = :email');
        $query->execute(['email' => $email]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            throw new Exception('User not found');
        }
        return new User(
            $result['id'],
            $result['email'],
            $result['password'],
            $result['origin'],
            $result['userType']
        );
    }

    public function login(string $email, string $password): User
    {
        $user = $this->getByEmail($email);
        if (!$this->verifyPassword($password, $user->password)) {
            throw new Exception('Invalid password');
        }
        return $user;
    }

    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private function verifyPassword(string $password, $hash): bool
    {
        return password_verify($password, $hash);
    }

    public function addUser(array $data): User
    {
        try {
            $this->getByEmail($data['email']);
            throw new Exception('User already exists');
        } catch (Exception $e) {
            if ($e->getMessage() != 'User not found') {
                throw $e;
            }
        }
        $query = $this->db->prepare('INSERT INTO User (email, password, origin, userType) VALUES (:email, :password, :origin, :userType)');
        $query->execute([
            'email' => $data['email'],
            'password' => $data['password'],
            'origin' => $data['origin'],
            'userType' => $data['userType']
        ]);
        $id = $this->db->lastInsertId();
        if ($data['userType'] == UserType::CANDIDATE->value) {
            $this->addCandidate($data['firstName'], $data['lastName'], $id);
        } else if ($data['userType'] == UserType::COMPANY->value) {
            $this->addCompany($data['companyName'], $data['location'], $data['description'], $id);
        }
        return new User(
            $id,
            $data['email'],
            $data['password'],
            $data['origin'],
            $data['userType']
        );
    }

    public function updateUser(User $user): void
    {
        $query = $this->db->prepare('UPDATE User SET email = :email, password = :password, origin = :origin WHERE id = :id');
        $query->execute([
            'id' => $user->id,
            'email' => $user->email,
            'password' => $user->password,
            'origin' => $user->origin
        ]);
    }

    public function deleteUser(int $id): void
    {
        $query = $this->db->prepare('DELETE FROM User WHERE id = :id');
        $query->execute(['id' => $id]);
    }

    private function addCandidate(string $firstName, string $lastName, int $userId): Candidate
    {
        echo 'addCandidate';
        $query = $this->db->prepare('INSERT INTO Candidate (firstName, lastName, userId) VALUES (:firstName, :lastName, :userId)');
        $query->execute([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'userId' => $userId
        ]);
        return new Candidate(
            $this->db->lastInsertId(),
            $firstName,
            $lastName,
            $userId
        );
    }

    public function getCandidate(int $userId): Candidate
    {
        $query = $this->db->prepare('SELECT * FROM Candidate WHERE userId = :userId');
        $query->execute(['userId' => $userId]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        return new Candidate(
            $result['id'],
            $result['firstName'],
            $result['lastName'],
            $result['userId']
        );
    }

    private function addCompany(string $name, string $location, string $description, int $userId): Company
    {
        echo 'addCompany';
        $query = $this->db->prepare('INSERT INTO Company (name, location, description, userId) VALUES (:name, :location, :description, :userId)');
        $query->execute([
            'name' => $name,
            'location' => $location,
            'description' => $description,
            'userId' => $userId
        ]);
        return new Company(
            $this->db->lastInsertId(),
            $name,
            $location,
            $description,
            $userId
        );
    }

    public function getCompany(int $userId): Company
    {
        $query = $this->db->prepare('SELECT * FROM Company WHERE userId = :userId');
        $query->execute(['userId' => $userId]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            throw new Exception('Company not found');
        }
        return new Company(
            $result['id'],
            $result['name'],
            $result['location'],
            $result['description'],
            $result['userId']
        );
    }


}
?>