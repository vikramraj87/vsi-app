<?php  namespace Kivi\Repositories;

use App\VirtualSlideProvider;

class VirtualSlideProviderRepository {
    public function all()
    {
        return VirtualSlideProvider::select(['id', 'name', 'url'])->orderBy('created_at')->get();
    }
} 