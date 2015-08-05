<?php

function index()
{

    $res = ModelPath::sharedInstance()->findAll();
    
    echo '<table>';
    echo '<tr>';
    echo '<td>Path</td>';
    echo '<td>Ignored</td>';
    echo '</tr>';
    foreach ($res as $row)
    {
        echo '<tr>';
        echo '<td>'.$row->path.'</td>';
        echo '<td>'.$row->ignored.'</td>';
        echo '<td><a class="button" href="'.KY::getRoute()->urlForRoute('path.delete',array('id'=>$row->id)).'">Delete</a></td>';
        echo '</tr>';
    }
    echo '</table>';
}

function addForm()
{
    KY::getView()->draw('path.add.form');     
}

function addShowFiles()
{

    echo "<script>\n";
    echo "var checkedValue = '';";
    echo "$('.checkbox').change(function() { if(this.checked) { checkedValue = this.val();} });";  
    echo "$('.ignored').append( checkedValue );";
    echo "</script>\n";
    echo "</head>\n";

    $currentDir = exec('pwd',$return); 
    $dir = $_POST['path'];  
    $ignored = array_map('trim', explode(",", $_POST['ignored']));

    $res = scandir($dir, 1);

    if (!$res)
    {
        echo "The path is not correct, please try again. For example, the path of the current file is: $currentDir";
    }
    else {

        $result = array();

        foreach($res as $key=> $value)
        {
            if ($value === '.' || $value === '..' || in_array($value, $ignored)) {
                continue;
            }
            if (is_dir($dir . '/' . $value)) 
            {
                //code to use if directory
                $result['folders'][] = $value;
            }
            else
            {
                $result['files'][] = $value;
            }
        }

        foreach ($result as $k => $r) {

            echo '<h3 style="text-transform:capitalize;">'.$k.': '.count($r).'</h3>';
            echo '<ul>';
            for ($i =0; $i < count($r); $i++)
            {
               echo '<li style="list-style-type:none;"><input class="checkbox" type="checkbox" value="'.$r[$i].'" />'.$r[$i].'</li>';
            }
            echo '</ul>';
        }

    }

    echo 'Do you wish to exclude other files or folders?';
    echo '<form method="POST" action="'.KY::getRoute()->urlForRoute('path.add.save').'">';
    echo '<input type="hidden" name="path" value="'.$_POST['path'].'"/>';
    echo '<input id="ignored" type="input" name="ignored" value="'.$_POST['ignored'].'"/><br/>';
    echo '<input type="submit" name="submit" value="Save"/>';
    echo '</form>';

}

function addSave()
{
    
    $path = new EntityPath();
    $path->path = $_POST['path'];
    $path->ignored = $_POST['ignored'];

    ModelPath::sharedInstance()->save($path);

    echo 'New path configuration created';
}


function delete($params)
{    
    $id = $params['id'];
    
    ModelPath::sharedInstance()->deleteById($id);
    ModelJobConf::sharedInstance()->deleteAssociatedJob($id, 'path');
    
}