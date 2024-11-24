<?php

namespace App\Orchid\Presenters;
use Orchid\Support\Presenter;
use Orchid\Screen\Contracts\Searchable;
use Laravel\Scout\Builder;

class BorrowerPresenter extends Presenter implements Searchable
{
    //Display the fullname
    public function fullName(): string
    {
        return sprintf('%s %s',
            $this->entity->first_name,
            $this->entity->last_name
        );
    }

    /**
     * @return string
     */
    public function label(): string
    {
        return 'Borrowers';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->fullName();
    }

    /**
     * @return string
     */
    public function subTitle(): string
    {
        return "";
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return url('/');
    }

    /**
     * @return string
     */
    public function image(): ?string
    {
        return null;
    }
    
    /**
     * @param string|null $query
     *
     * @return Builder
     */
    public function searchQuery(string $query = null): Builder
    {
        return $this->entity->search($query);
    }
    
    /**
     * @return int
     */
    public function perSearchShow(): int
    {
        return 3;
    }
}
