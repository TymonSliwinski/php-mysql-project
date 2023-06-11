<?php

class Application
{
    public int $id;
    public string $description;
    public int $candidateId;
    public int $offerId;
    public string $createdAt;

    public function __construct(int $id, string $description, int $candidateId, int $offerId, string $createdAt)
    {
        $this->id = $id;
        $this->description = $description;
        $this->candidateId = $candidateId;
        $this->offerId = $offerId;
        $this->createdAt = $createdAt;
    }
}

class ApplicationsModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getOne(int $id): Application
    {
        $query = $this->db->prepare('SELECT * FROM Application WHERE id = :id');
        $query->execute(['id' => $id]);
        $application = $query->fetch();

        return new Application(
            $application['id'],
            $application['description'],
            $application['candidateId'],
            $application['offerId'],
            $application['createdAt']
        );
    }

    public function getAll(): array
    {
        $query = $this->db->prepare('SELECT * FROM Application');
        $query->execute();
        $applications = $query->fetchAll();

        return $applications;
    }

    public function getAllByCandidateId(int $candidateId): array
    {
        $query = $this->db->prepare('SELECT Company.name AS companyName, Offer.title AS offerTitle, Application.description AS description, Application.createdAt AS date FROM Application INNER JOIN Offer ON Application.offerId = Offer.id INNER JOIN Company ON Offer.companyId = Company.id WHERE candidateId = :candidateId ORDER BY Application.createdAt DESC');
        $query->execute(['candidateId' => $candidateId]);
        $applications = $query->fetchAll();

        return $applications;
    }

    public function getAllByOfferId(int $offerId): array
    {
        $query = $this->db->prepare('SELECT * FROM Application WHERE offerId = :offerId');
        $query->execute(['offerId' => $offerId]);
        $applications = $query->fetchAll();

        return $applications;
    }

    public function getAllByCompanyId(int $companyId): array {
        $query = $this->db->prepare('SELECT Candidate.firstName as firstName, Candidate.lastName AS lastName, Offer.title as offerTitle, Application.description as description, Application.createdAt as date FROM Application INNER JOIN Offer ON Application.offerId = Offer.id INNER JOIN Candidate ON Application.candidateId = Candidate.id WHERE Offer.companyId IN (SELECT id FROM Offer WHERE companyId = :companyId) ORDER BY Application.createdAt DESC');
        $query->execute(['companyId' => $companyId]);
        $applications = $query->fetchAll();
        return $applications;
    }

    public function addApplication(string $description, int $candidateId, int $offerId): Application
    {
        $query = $this->db->prepare('INSERT INTO Application (description, candidateId, offerId) VALUES (:description, :candidateId, :offerId)');
        $query->execute(['description' => $description, 'candidateId' => $candidateId, 'offerId' => $offerId]);
        $id = $this->db->lastInsertId();
        $application = $this->getOne($id);
        return $application;
    }

    public function updateApplication(Application $application): Application
    {
        $query = $this->db->prepare('UPDATE Application SET description = :description, candidateId = :candidateId, offerId = :offerId WHERE id = :id');
        $query->execute([
            'id' => $application->id,
            'description' => $application->description,
            'candidateId' => $application->candidateId,
            'offerId' => $application->offerId
        ]);
        return $application;
    }

    public function deleteApplication(int $id): void
    {
        $query = $this->db->prepare('DELETE FROM Application WHERE id = :id');
        $query->execute(['id' => $id]);
    }
}

?>