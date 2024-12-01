<?php
class GetPets
{
    public $pets;
    public $count;
    private $args = [];
    private $placeholders = [];
    private $conditions = [];

    public function __construct()
    {
        global $wpdb;
        $tablename = $wpdb->prefix . "pets";

        $this->getArgs();

        $query = "SELECT * FROM $tablename ";
        $countQuery = "SELECT COUNT(*) FROM $tablename ";
        if (!empty($this->conditions)) {
            $query .= "WHERE " . implode(' AND ', $this->conditions);
            $countQuery .= "WHERE " . implode(' AND ', $this->conditions);
        }
        $query .= " LIMIT 100";

        // Only prepare the query if there are placeholders to avoid SQL errors
        if (!empty($this->placeholders)) {
            $query = $wpdb->prepare($query, $this->placeholders);
            $this->count = $wpdb->get_var($wpdb->prepare($countQuery, $this->placeholders));
        }

        $this->pets = $wpdb->get_results($query);
    }

    private function getArgs()
    {
        $params = [
            'favcolor' => '%s',
            'species' => '%s',
            'minyear' => '%d',
            'maxyear' => '%d',
            'minweight' => '%d',
            'maxweight' => '%d',
            'favhobby' => '%s',
            'favfood' => '%s',
        ];

        foreach ($params as $key => $placeholder) {
            if (!empty($_GET[$key])) {
                $value = sanitize_text_field($_GET[$key]);
                $this->args[$key] = $value;
                $this->placeholders[] = $value;
                $this->conditions[] = $this->buildCondition($key, $placeholder);
            }
        }
    }

    private function buildCondition($key, $placeholder)
    {
        switch ($key) {
            case "minweight":
                return "petweight >= $placeholder";
            case "maxweight":
                return "petweight <= $placeholder";
            case "minyear":
                return "birthyear >= $placeholder";
            case "maxyear":
                return "birthyear <= $placeholder";
            default:
                return "$key = $placeholder";
        }
    }
}
