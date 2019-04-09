<?php

namespace FastDog\Admin\Events;


use Illuminate\Database\Eloquent\Model;

/**
 * Редактирование домена
 *
 * @package App\Modules\Config\Events
 * @version 0.2.0
 * @author Андрей Мартынов <d.g.dev482@gmail.com>
 */
class AdminMenuEvent
{
    /**
     * @var array $data
     */
    protected $data = [];

    /**
     * @var array $result
     */
    protected $result = [];


    /**
     * @param array $result
     */
    public function __construct(array &$result)
    {
        $this->result = &$result;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @param array $result
     * @return void
     */
    public function setResult(array $result): void
    {
        $this->result = $result;
    }
}
