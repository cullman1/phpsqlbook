<?php
class User {
    public $name;
    public $age;
    public $member;

    public function __construct($name, $age, $member) {
        $this->name   = $name;
        $this->age    = $age;
        $this->member = $member;
    }
}

$user = new User('Ivy', 10, TRUE);
?>

<h1>print_r()</h1>
<?php print_r($user); ?>

<h1>var_dump()</h1>
<?php var_dump($user); ?>