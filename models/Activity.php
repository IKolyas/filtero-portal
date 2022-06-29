<?php

namespace app\models;

use app\models\repositories\ActivityRepository;

class Activity extends Model
{

    public int $id;
    public string $title;
    public int $institute_id;
    public int $activity_type_id;
    public int $user_id;
    public int $age_from;
    public int $age_to;
    public int $amount_of_week;
    public int $duration_time;
    public float $price;
    public float $price_month;
    public string $contacts;


    public function __construct()
    {
        $this->repository = new ActivityRepository();
    }

    public function getAgeRange(): string
    {
        return "{$this->age_from} - {$this->age_to} лет";
    }

    public function getAmountOfWeek(): string
    {
        if ($this->amount_of_week != 2 && $this->amount_of_week != 3 && $this->amount_of_week != 4) 
        {
            return "$this->amount_of_week раз";
        }
        else 
        {
            return "$this->amount_of_week раза";
        }
        
    }

    protected function getActivitiesFields(&$activities): Activity
    {
        foreach ($activities as $activity) {
            $activity->age = $activity->getAgeRange();
            $activity->amountOfWeek = $activity->getAmountOfWeek();
            $activity->priceFormated = $activity->convertToMoneyFormat($activity->price);
            $activity->priceMonthFormated = $activity->convertToMoneyFormat($activity->price_month);
        }
        return $this;
    }

    protected function getAges(): array
    {
        $agesArray = array();
        $agesFrom = $this->repository->getAgesFrom();
        $agesTo = $this->repository->getAgesTo();
        foreach ($agesFrom as $age){
            array_push($agesArray, $age->age_from);
        }
        foreach ($agesTo   as $age){
            array_push($agesArray, $age->age_to);
        }
        $agesArray = array_unique($agesArray);
        sort($agesArray);
        return $agesArray;
    }

    protected function getPrice(): array
    {
        $priceArray = array();
        $prices = $this->repository->getPrice();
        foreach ($prices as $price){
            array_push($priceArray, $price->price);
        }
        $priceArray = array_unique($priceArray);
        sort($priceArray);
        return $priceArray;
    }

    public function select(array $fields): Activity
    {
        $this->repository->select($fields);
        return $this;
    }

    public function type(string $type): Activity
    {
        $decodedType = urldecode($type);
        $this->repository->type($decodedType);
        return $this;
    }

    public function institute(string $institute): Activity
    {
        $decodedInstitute = urldecode($institute);
        $this->repository->institute($decodedInstitute);
        return $this;
    }

    public function age_from(string $age_from, string $age_to): Activity
    {
        $this->repository->age_from($age_from, $age_to);
        return $this;
    }

    public function price(string $price_from, string $price_to): Activity
    {
        $this->repository->price($price_from, $price_to);
        return $this;
    }

    public function search(string $search): Activity
    {
        $search = preg_replace('/\s+/', " ", urldecode($search));
        $search = str_replace(" ", ".*", $search);

        $this->repository->search($search);
        return $this;
    }

    public function orderBy(string $order_by): Activity
    {
        $this->repository->orderBy($order_by);
        return $this;
    }

    public function order(string $order): Activity
    {
        $this->repository->order($order);
        return $this;
    }

    public function paginate(int $offset, int $paginate): Activity
    {
        $this->repository->paginate($offset, $paginate);
        return $this;
    }

    public function leftJoin(string $table, string $for_key, string $prim_key): Activity
    {
        $this->repository->leftJoin($table, $for_key, $prim_key);
        return $this;
    }

    public function get(): array
    {
        return $this->repository->getQuery($this->repository->query, []);
    }

    protected function getActivitiesIndex(): Activity
    {
        $this->select([
            '
            activities.id,
            activities.title,
            activities.age_from,
            activities.age_to,
            activities.amount_of_week,
            activities.duration_time,
            activities.price,
            activities.price_month,
            activities.contacts,
            institutes.title as institute_title,
            activity_types.title as type_title
           '
        ])
            ->leftJoin('institutes', 'institute_id', 'institutes.id')
            ->leftJoin('activity_types', 'activity_type_id', 'activity_types.id')

        ;

        return $this;
    }

    public function renderMain($activities): string
    {
        $html = '';
        foreach ($activities as $activity) {
            $html .= app()->renderer->render('activities.item', compact('activity'));
        }
        return $html;
    }

    public function renderMobile($activities): string
    {
        $html_mobile = '';
        foreach ($activities as $activity) {
            $html_mobile .= app()->renderer->render('activities.item_mobile', compact('activity'));
        }
        return $html_mobile;
    }

    public function isAjax(): bool 
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    public function convertToMoneyFormat($price): string
    {
        if ($price * 100 % 100 > 0) 
        {
            return number_format($price, 2, '.', ' ');
        }
        else 
        {
            return substr(number_format($price, 2, '.', ' '), 0, -3);
        }
        
    }
}