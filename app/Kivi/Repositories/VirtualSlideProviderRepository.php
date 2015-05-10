<?php  namespace Kivi\Repositories;

use App\VirtualSlideProvider;

class VirtualSlideProviderRepository {
    public function all()
    {
        return VirtualSlideProvider::all();
    }
} 