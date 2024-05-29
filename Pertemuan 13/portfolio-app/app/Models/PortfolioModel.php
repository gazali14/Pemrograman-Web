<?php
namespace App\Models;
use CodeIgniter\Model;
class PortfolioModel extends Model
{
    protected $table = 'portfolios';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'App\Entities\Portfolio';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['title', 'description', 'image'];
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
}