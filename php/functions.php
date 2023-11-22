<?php 
session_start();
require_once "handler.php";

//system messages
$connection_error = "There was a connection error! Please try agian!";

function add_Students_Parents ($StudentsLink, $ParentsLink) {
    $db = new database ();
    $stm = "INSERT INTO Students_Parents SET 
        StudentsLink = :StudentsLink,
        ParentsLink = :ParentsLink,
        UsersId = :UsersId
    ;";
    $db->query($stm);
    $db->bind(":StudentsLink", $StudentsLink);
    $db->bind(":ParentsLink", $ParentsLink);
    $db->bind(":UsersId", $_SESSION['Id']);
    $db->execute();
}

//function to generate pro forma invoice for monthly fees
function generate_pro_forma_invoice ($StudentsLink, $ClassesLink) {
    //getting data from the table Classes 
    $db = new database ();
    $stm = "SELECT * FROM Classes WHERE Link = :ClassesLink ;";
    $db->query($stm);
    $db->bind(":ClassesLink", $ClassesLink);
    $rows_Classes = $db->resultset();

    foreach ($rows_Classes as $row_Classes) {
        #code...
    }
    $start_year = date("Y", strtotime($row_Classes->StartDate));
    $end_year = date("Y", strtotime($row_Classes->EndDate));
    $start_month = date("m", strtotime($row_Classes->StartDate));
    $end_month = date("m", strtotime($row_Classes->EndDate));
    $num_months = (($end_year - $start_year) * 12) + ($end_month - $start_month);
    $i = 0;
    while ($i <= $num_months) {
        $current_month = date("M-Y", strtotime($row_Classes->StartDate."+ $i months"));
        $Deadline = date("Y-m", strtotime($current_month))."-07"; 
        //creating an invoice Link
        $Link = uniqid("Inv_", true);
        //inserting data to the table Invoices
        $stm = "INSERT INTO Invoices SET 
            Link = :Link, 
            StudentsLink = :StudentsLink,
            Deadline = :Deadline, 
            UsersId = :UsersId
        ;";
        $db->query($stm);
        $db->bind(":Link", $Link);
        $db->bind(":StudentsLink", $StudentsLink);
        $db->bind(":Deadline", $Deadline);
        $db->bind(":UsersId", $_SESSION['Id']);
        if ($db->execute()) {
            $Description = "Monthly Fees for the month of ".$current_month;
            $Invoices_DetailsLink = uniqid("Inv_Dtl_", true);
            //inserting data to the table Invoices_Details
            $stm = "INSERT INTO Invoices_Details SET
                Link = :Link, 
                InvoicesLink = :InvoicesLink, 
                Description = :Description, 
                MMK = :MMK
            ;";
            $db->query($stm);
            $db->bind(":Link", $Invoices_DetailsLink);
            $db->bind(":InvoicesLink", $Link);
            $db->bind(":Description", $Description);
            $db->bind(":MMK", $row_Classes->Monthly);
            $db->execute();
        }
        $i++;
    }
}

//function to generate InvoiceNo for table Invoices 
function generate_InvoiceNo () {
    $db = new database();
    $stm = "SELECT * FROM Invoices WHERE InvoiceNo != '' ;";
    $db->query($stm);
    $row_count = $db->row_count();
    $n = $row_count + 1; 
    if ($n < 9) {
        $zeros = '00000';    
    }
    elseif ($n < 99) {
        $zeros = '0000';
    }
    elseif ($n < 999) {
        $zeros = '000';
    }
    elseif ($n < 9999) {
        $zeros = '00';
    }
    elseif ($n < 99999) {
        $zeros = '0';
    }
    else {
        $zeros = '';
    }
    $ym = date("ym");
    return $InvoiceNo = $ym.$zeros.$n;
}

//This cool function that converts number to words doesn't belong to me
function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    return $string;
}

?>
