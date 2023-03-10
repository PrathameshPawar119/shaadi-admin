<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Company extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'creator', 'name', 'title', 'about', 'email', 'services', 'website', 'industry_type', 'location', 'company_size', 'main_city', 'available_cities', 'founded', 'reports'
    ];

    protected $casts = [
        'services' => 'array',
        'available_cities' => 'array'
    ];

    //Industry types
    public const PAINTING = 'painting_contractor';
    public const PLUMBING = 'plumbing_contractor';
    public const CARPENTRY = 'carpentry_contractor';
    public const DRIVING = 'driving_services';
    public const ELECTRIC = 'electrician_contractor';
    public const INTERIOR = 'interior_contractor';
    public const CONSTRUCTION = 'construction_contractor';

    public const IndustryTypes = [
        self::PAINTING => 'Painting Contractor',
        self::PLUMBING => 'Plumbing Contractor',
        self::CARPENTRY => 'Carpentry Contractor',
        self::DRIVING => 'Driving Services',
        self::ELECTRIC => 'Electrician Contractor',
        self::INTERIOR => 'Interior Contractor',
        self::CONSTRUCTION => 'Construction Contractor'
    ];

    // Company Size
    public const SMALL = 'small';
    public const MEDIUM = 'medium';
    public const LARGE = 'large';
    public const ENTERPRISE = 'enterprise';
    public const MNC = 'mnc';

    public const CompanySize = [
        self::SMALL => 'Small',
        self::MEDIUM => 'Medium',
        self::LARGE => 'Large',
        self::ENTERPRISE => 'Enterprises',
        self::MNC => 'MNC'
    ];



}


