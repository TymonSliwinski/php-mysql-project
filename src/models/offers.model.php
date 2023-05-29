<?php
enum Category
{
    case BACKEND;
    case FRONTEND;
    case DEVOPS;
    case PM;
    case FULLSTACK;
    case DATA;
    case DESIGN;
}

class Offer
{
    public int $id;
    public string $title;
    public string $description;
    public Category $category;
    public string $requirements;
    public string $location;
    public int $salaryLower;
    public int $salaryUpper;
    public string $createdAt;
    public int $companyId;

    public function __construct(int $id, string $title, string $description, Category $category, string $requirements, string $location, int $salaryLower, int $salaryUpper, string $createdAt, int $companyId)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->category = $category;
        $this->requirements = $requirements;
        $this->location = $location;
        $this->salaryLower = $salaryLower;
        $this->salaryUpper = $salaryUpper;
        $this->createdAt = $createdAt;
        $this->companyId = $companyId;
    }
}

class OffersModel
{
    private PDO $db;

    public function __construct(PDO $dbh)
    {
        $this->db = $dbh;
    }

    public function getOne(int $id)
    {
        $stmt = $this->db->prepare('SELECT * FROM offers WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $offer = $stmt->fetch();
        return $offer;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare('SELECT * FROM offers');
        $stmt->execute();
        $offers = $stmt->fetchAll();
        return $offers;
    }

    public function addOffer(string $title, string $description, Category $category, string $requirements, string $location, int $salaryLower, int $salaryUpper, string $createdAt, int $companyId): Offer
    {
        $stmt = $this->db->prepare('INSERT INTO offers (title, description, category, requirements, location, salary_lower, salary_upper, created_at, company_id) VALUES (:title, :description, :category, :requirements, :location, :salary_lower, :salary_upper, :created_at, :company_id)');
        $stmt->execute(['title' => $title, 'description' => $description, 'category' => $category, 'requirements' => $requirements, 'location' => $location, 'salary_lower' => $salaryLower, 'salary_upper' => $salaryUpper, 'created_at' => $createdAt, 'company_id' => $companyId]);
        $offer = $stmt->fetch(); // sprawdzic czy to dziala i zwraca id
        return $offer;
    }

    public function updateOffer(Offer $data)
    {

    }

    public function deleteOffer(int $id)
    {

    }
}
?>