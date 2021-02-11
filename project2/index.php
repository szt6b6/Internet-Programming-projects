<?php
session_start();
/**
 * Animal class, represent each animal object
 */
class Animal
{
    var $name;
    var $rating;
    var $comment;
    var $status;
    var $weight;
    var $size;
    var $color;

    public function __construct($name, $rating, $comment, $status, $weight, $size, $color)
    {
        $this->name = $name;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->status = $status;
        $this->weight = $weight;
        $this->size = $size;
        $this->color = $color;
    }

    public function __toString()
    {
        return <<<EOD
                    <tr>
                        <form method="post" action="index.php?edit=$this->name" required>
                            <th><input type="text" name="name" value="$this->name" required/></th>
                            <th><input type="number" name="rating" value="$this->rating" required/></th>  
                            <th><input type="text" name="comment" value="$this->comment" required/></th>
                            <th><input type="text" name="status" value="$this->status" required/></th>
                            <th><input type="number" name="weight" value="$this->weight" required/></th>
                            <th><input type="text" name="size" value="$this->size" required/></th>
                            <th><input type="text" name="color" value="$this->color" required/></th>
                            <th><input type="submit" name="update" value="update" required/></th>
                        </form>
                    </tr>
EOD;
    }

    public function toOverview()
    {
        return <<<EOD
                <tr>
                    <form method="post" action="index.php?detail=$this->name">
                        <th><input type="text" name="name" value="$this->name" readonly></th>
                        <th><input type="text" name="comment" value="$this->comment" readonly/></th>
                        <th><input type="number" name="weight" value="$this->weight" readonly/></th>
                        <th><input type="text" name="size" value="$this->size" readonly/></th>
                        <th><input type="text" name="color" value="$this->color" readonly/></th>
                        <th><input type="submit" name="detail" value="detail"/></th>
                    </form>
                    <form method="post" action="index.php?delete=$this->name">
                        <th><input type="submit" name="delete" value="delete" /></th>
                    </form>
                </tr>
EOD;
    }


    public function edit($name, $rating, $comment, $status, $weight, $size, $color)
    {
        $this->name = $name;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->status = $status;
        $this->weight = $weight;
        $this->size = $size;
        $this->color = $color;
    }
}

/**
 * Animals class, used to store the ten animals object and it has many methods to edit those animals object
 */
class Animals
{
    var $allAnimals;

    public function __construct()
    {
        $this->allAnimals = unserialize($_SESSION['list']);
    }

    //add animal, and detect duplicated name
    public function add_animal($animal)
    {
        if ($this->allAnimals != null) {
            foreach ($this->allAnimals as $in_animal) {
                if ($in_animal->name == $animal->name) {
                    echo "Erroring. Duplicate name " . $in_animal->name;
                    return;
                }
            }
        }

        $this->allAnimals[] = $animal;
        $_SESSION['list'] = serialize($this->allAnimals);
    }

    //delete animal from list according name
    public function delete_animal($animalName)
    {
        $index = 0;
        foreach ($this->allAnimals as $animal) {
            if ($animal->name == $animalName)
                unset($this->allAnimals[$index]);
            $index++;
        }
        $this->allAnimals = array_values($this->allAnimals);
        $_SESSION['list'] = serialize($this->allAnimals);
    }

    //update information of one animal object
    public function update_animal($animalName)
    {
        foreach ($this->allAnimals as $animal) {
            if ($animal->name == $animalName)
                $animal->edit($_POST['name'], $_POST['rating'], $_POST['comment'], $_POST['status'], $_POST['weight'], $_POST['size'], $_POST['color']);
        }
        $_SESSION["list"] = serialize($this->allAnimals);
    }

    //get one animal from list according to name
    public function get_animal($animalName)
    {
        foreach ($this->allAnimals as $animal) {
            if ($animal->name == $animalName)
                return $animal;
        }
        return null;
    }

    public function sort_by_name()
    {
        $i = 0;
        for ($i = 0; $i < count($this->allAnimals); $i++) {
            $j = 0;
            for ($j = count($this->allAnimals) - 1; $j > $i; $j--) {
                if (strcmp($this->allAnimals[$j]->name, $this->allAnimals[$j - 1]->name) < 0) {
                    $temp = $this->allAnimals[$j];
                    $this->allAnimals[$j] = $this->allAnimals[$j - 1];
                    $this->allAnimals[$j - 1] = $temp;
                }
            }
        }
        $this->allAnimals = array_values($this->allAnimals);
        $_SESSION['list'] = serialize($this->allAnimals);
    }

    public function sort_by_weight()
    {
        $i = 0;
        for ($i = 0; $i < count($this->allAnimals); $i++) {
            $j = 0;
            for ($j = count($this->allAnimals) - 1; $j > $i; $j--) {
                if ($this->allAnimals[$j]->weight < $this->allAnimals[$j - 1]->weight) {
                    $temp = $this->allAnimals[$j];
                    $this->allAnimals[$j] = $this->allAnimals[$j - 1];
                    $this->allAnimals[$j - 1] = $temp;
                }
            }
        }
        $this->allAnimals = array_values($this->allAnimals);
        $_SESSION['list'] = serialize($this->allAnimals);
    }

    public function sort_by_color()
    {
        $i = 0;
        for ($i = 0; $i < count($this->allAnimals); $i++) {
            $j = 0;
            for ($j = count($this->allAnimals) - 1; $j > $i; $j--) {
                if (strcmp($this->allAnimals[$j]->color, $this->allAnimals[$j - 1]->color) < 0) {
                    $temp = $this->allAnimals[$j];
                    $this->allAnimals[$j] = $this->allAnimals[$j - 1];
                    $this->allAnimals[$j - 1] = $temp;
                }
            }
        }
        $this->allAnimals = array_values($this->allAnimals);
        $_SESSION['list'] = serialize($this->allAnimals);
    }

    public function sort_by_size()
    {
        $i = 0;
        for ($i = 0; $i < count($this->allAnimals); $i++) {
            $j = 0;
            for ($j = count($this->allAnimals) - 1; $j > $i; $j--) {
                if (strcmp($this->allAnimals[$j]->size, $this->allAnimals[$j - 1]->size) < 0) {
                    $temp = $this->allAnimals[$j];
                    $this->allAnimals[$j] = $this->allAnimals[$j - 1];
                    $this->allAnimals[$j - 1] = $temp;
                }
            }
        }
        $this->allAnimals = array_values($this->allAnimals);
        $_SESSION['list'] = serialize($this->allAnimals);
    }
}

?>
<html>
    <head>
        <link rel="stylesheet" href="css/index.css">
    </head>

    <body>
            <table>
                <caption>Overview of Animals</caption>
                <tr>
                    <th>name</th>
                    <th>comment</th>
                    <th>weight /kg</th>
                    <th>size</th>
                    <th>color</th>                    
                    <th>overview</th>
                    <th>delete</th>
                </tr>
<!-- I found on each request to this page the all php code will excute once, and the contend excuted variable are all cleared. Thus the contend of animals are stored in $_SESSION varaible -->
<?php
//according to the different kinds of request, depend responsive behavior


// http://localhost/ page, used to init the cache
if ($_SERVER['REQUEST_URI'] == "/") {
    $_SESSION['list'] = null;
    //public function __construct($name, $rating, $comment, $status, $weight, $size, $color)
    $cup = new Animal("lion", 9, "lion, the king adn hunter of Africa", "king", 400, "big", "brown");
    $cup2 = new Animal("tiger", 10, "usually in forest, firce and beautiful hunter at top food link", "top hunter, king", 500, "big", "yellow");
    $cup3 = new Animal("elephen", 7, "super big animal", "their tooth is beautiful", 2500, "super big", "gray");
    $cup4 = new Animal("rabbit", 2, "cute rabbit, cute you", "small animal", 3, "small", "gray");
    $cup5 = new Animal("mouse", 1, "we hate mouse, zhi,zhi,zhi", "shit mouse", 0.5, "small", "gray");
    $cup6 = new Animal("golden fish", 2, "fish is dicilious, i like it", "eat fish", 1, "small", "golden");
    $cup7 = new Animal("kangroo", 7, "fighter with strong mulse", "fighter", 100, "big", "brown");
    $cup8 = new Animal("panda", 6, "chinese baby, so cute, represent of lucky", "animal baby", 100, "big", "black and white");
    $cup9 = new Animal("snake", 9, "not big but dangerous", "do touch me", 1, "small", "gray");
    $cup10 = new Animal("panguin", 5, "at south polar, a animal belong ot bird", "normal but cute", 50, "meiddle", "white and black");

    $animals = new Animals();
    $animals->add_animal($cup);
    $animals->add_animal($cup2);
    $animals->add_animal($cup3);
    $animals->add_animal($cup4);
    $animals->add_animal($cup5);
    $animals->add_animal($cup6);
    $animals->add_animal($cup7);
    $animals->add_animal($cup8);
    $animals->add_animal($cup9);
    $animals->add_animal($cup10);

    foreach ($animals->allAnimals as $animal) {
        echo $animal->toOverview();
    }
}


//sort by name
else if (isset($_GET['sort_by'])) {
    $animals = new Animals();
    if ($animals->allAnimals == null) {
        echo "<h>No cache in SESSION</h>";
    }
    else {
        $sort_by = $_GET['sort_by'];
        switch ($sort_by) {
            case 'name':
                $animals->sort_by_name();
                break;
            case 'weight':
                $animals->sort_by_weight();
                break;
            case 'size':
                $animals->sort_by_size();
                break;
            case 'color':
                $animals->sort_by_color();
                break;
            default:
                break;
        }
        foreach ($animals->allAnimals as $animal) {
            echo $animal->toOverview();
        }
    }

}

//update item
else if (isset($_GET['edit'])) {
    $animals = new Animals();
    $edit_name = $_GET['edit'];
    $animals->update_animal($edit_name);
    foreach ($animals->allAnimals as $animal) {
        echo $animal->toOverview();
    }
}
//delete item
else if (isset($_GET['delete'])) {
    $animals = new Animals();
    $delete_name = $_GET['delete'];
    $animals->delete_animal($delete_name);
    foreach ($animals->allAnimals as $animal) {
        echo $animal->toOverview();
    }
}

//create item
else if (isset($_GET['create'])) {
    $animals = new Animals();
    $temp = new Animal($_POST['name'], $_POST['rating'], $_POST['comment'], $_POST['status'], $_POST['weight'], $_POST['size'], $_POST['color']);
    $animals->add_animal($temp);
    foreach ($animals->allAnimals as $animal) {
        echo $animal->toOverview();
    }
}

//detail, show animal in overview panel
else if (isset($_GET['detail'])) {
    $animals = new Animals();
    foreach ($animals->allAnimals as $animal) {
        echo $animal->toOverview();
    }
}

//clear cache session
else if (isset($_GET['clearSession'])) {
    $_SESSION['list'] = null;
}

?>
                </table>
                <br><br>

                <table>
                    <caption>create animal</caption>
                    <tr>
                        <th>name</th>
                        <th>rating</th>
                        <th>comment</th>
                        <th>status</th>
                        <th>weight /kg</th>
                        <th>size</th>
                        <th>color</th>
                        <th>create</th>
                    </tr>
                    <tr>
                        <form method="post" action="index.php?create=yes">
                            <th><input type="text" name="name" value="" required/></th>
                            <th><input type="number" name="rating" value="" required/></th>  
                            <th><input type="text" name="comment" value="" required/></th>
                            <th><input type="text" name="status" value="" required/></th>
                            <th><input type="number" name="weight" value="" required/></th>
                            <th><input type="text" name="size" value="" required/></th>
                            <th><input type="text" name="color" value="" required/></th>
                            <th colspan="2"><input type="submit" name="create" value="create"/></th>
                        </form>
                    </tr>

                </table>
                <br><br>

<?php
//detail, after clikk the detail of someline, show the detail information
if (isset($_GET['detail'])) {
    $animals = new Animals();
    $name = $_GET['detail'];

    $animal = $animals->get_animal($name);
    echo <<<EOD
                                    <table>
                                        <caption>detail of animal</caption>
                                        <tr>
                                            <th>name</th>
                                            <th>rating</th>
                                            <th>comment</th>
                                            <th>status</th>
                                            <th>weight</th>
                                            <th>size</th>
                                            <th>color</th>
                                            <th>update</th>
                                        </tr>
                                        $animal
                                    </table>
EOD;
}
?>
                    <div>
                        <form class="function_button" method="post" action="/">
                            <input type="submit" name="home" value="restore cache" />
                        </form>
                        <form class="function_button" method="post" action="index.php?clearSession=yes">
                            <input type="submit" name="clearCache" value="clear cache" />
                        </form>
                        <form class="function_button" method="post" action="index.php?sort_by=name">
                            <input type="submit" name="name" value="sort by name"/>
                        </form>
                        <form class="function_button" method="post" action="index.php?sort_by=weight">
                            <input type="submit" name="weight" value="sort by weight"/>
                        </form>
                        <form class="function_button" method="post" action="index.php?sort_by=size">
                            <input type="submit" name="size" value="sort by size"/>
                        </form>
                        <form class="function_button" method="post" action="index.php?sort_by=color">
                            <input type="submit" name="color" value="sort by color"/>
                        </form>
                    <div>
    </body>
</html>


