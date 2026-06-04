<?php

namespace Lightit\Doctors\Domain\Actions;

use Illuminate\Pagination\LengthAwarePaginator;
use Lightit\Doctors\Domain\Models\Doctor;
use Spatie\QueryBuilder\QueryBuilder;

class ListDoctorAction
{
    public function execute(): LengthAwarePaginator
    {
        return QueryBuilder::for(Doctor::class)
            ->orderByDesc('id')
            ->paginate();
    }
}
