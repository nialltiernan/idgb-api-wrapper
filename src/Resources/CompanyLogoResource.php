<?php
declare(strict_types=1);

namespace Igdb\Resources;

use Igdb\Response;

class CompanyLogoResource extends Resource
{

    function fetch(string $query = ''): Response
    {
        return $this->get('company_logos', $query);
    }
}
