<?php
namespace Ricci69\MmbakViewer;

class Currencies
{
    private $db;

    public function __construct(DbDriver $Db)
    {
        $this->db = $Db->db;
    }

    /**
     * Returns the list of the currencies
     * 
     * @return array [CURRENCY_ID] = SYMBOL
     */
    public function get() : array
    {
        $currency = array();
        $results = $this->db->query('SELECT * FROM CURRENCY');
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $currency[$row["uid"]] = $row["SYMBOL"];
        }

        return $currency;
    }
}
