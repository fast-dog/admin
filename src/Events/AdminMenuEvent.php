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
     * DomainsItemAdminPrepare constructor.
     * @param array $data
     * @param array $result
     */
    public function __construct(array &$data, array &$result)
    {
        $this->data = &$data;
        $this->item = &$item;
        $this->result = &$result;
    }


    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
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
