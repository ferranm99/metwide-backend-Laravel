<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteEnquire extends Model
{
    public $table = 'website_enquiries';
    
    protected $fillable = ['name', 'email', 'phone', 'state', 'property_type', 'best_time_to_call', 'current_customer',
        'enquiry_type', 'enquiry_message', 'status', 'date_closed', 'site_code'];
}

