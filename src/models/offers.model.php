<?php
enum Category: string
{
    case BACKEND = "BACKEND";
    case FRONTEND = "FRONTEND";
    case DEVOPS = "DEVOPS";
    case PM = "PM";
    case FULLSTACK = "FULLSTACK";
    case DATA = "DATA";
    case DESIGN = "DESIGN";
}

class Offer
{
    public int $id;
    public string $title;
    public string $description;
    public string $category;
    public string $requirements;
    public string $location;
    public int $salaryLower;
    public int $salaryUpper;
    public string $createdAt;
    public int $companyId;

    public function __construct(int $id, string $title, string $description, string $category, string $requirements, string $location, int $salaryLower, int $salaryUpper, string $createdAt, int $companyId)
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
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getOne(int $id): Offer
    {
        $query = $this->db->prepare('SELECT * FROM Offer WHERE id = :id');
        $query->execute(['id' => $id]);
        $offer = $query->fetch();
        return new Offer(
            $offer['id'],
            $offer['title'],
            $offer['description'],
            $offer['category'],
            $offer['requirements'],
            $offer['location'],
            $offer['salaryLower'],
            $offer['salaryUpper'],
            $offer['createdAt'],
            $offer['companyId']
        );
    }

    public function getAll()
    {
        $query = $this->db->prepare('SELECT * FROM Offer ORDER BY createdAt DESC');
        $query->execute();
        $offers = $query->fetchAll();
        return $offers;
    }

    public function addOffer(string $title, string $description, string $category, string $requirements, string $location, int $salaryLower, int $salaryUpper, int $companyId): Offer
    {
        $query = $this->db->prepare('INSERT INTO Offer (title, description, category, requirements, location, salaryLower, salaryUpper, companyId) VALUES (:title, :description, :category, :requirements, :location, :salaryLower, :salaryUpper, :companyId)');
        $query->execute(['title' => $title, 'description' => $description, 'category' => $category, 'requirements' => $requirements, 'location' => $location, 'salaryLower' => $salaryLower, 'salaryUpper' => $salaryUpper, 'companyId' => $companyId]);
        $offer = $query->fetch(); // sprawdzic czy to dziala i zwraca id
        $id = $this->db->lastInsertId();
        $offer = $this->getOne($id);
        return $offer;
    }

    public function updateOffer(Offer $offer): Offer
    {
        $query = $this->db->prepare('UPDATE Offer SET title = :title, description = :description, category = :category, requirements = :requirements, location = :location, salaryLower = :salaryLower, salaryUpper = :salaryUpper, companyId = :companyId WHERE id = :id');
        $query->execute(['title' => $offer->title, 'description' => $offer->description, 'category' => $offer->category, 'requirements' => $offer->requirements, 'location' => $offer->location, 'salaryLower' => $offer->salaryLower, 'salaryUpper' => $offer->salaryUpper, 'companyId' => $offer->companyId, 'id' => $offer->id]);
        return $query->fetch();
    }

    public function deleteOffer(int $id)
    {
        $query = $this->db->prepare('DELETE FROM Offer WHERE id = :id');
        $query->execute(['id' => $id]);
        return $query->fetch();
    }
}
?>