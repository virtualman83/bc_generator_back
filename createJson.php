<?php

function createJSON($folder)
{
    $files = explode(",,", explore($folder));
    $json = array();
    for ($i = 0; $i < count($files) - 1; ++$i)
    {
        $current = $files[$i];
        $json[] = array(str_replace($folder, '', $current), date('Y-m-d H:i:s', filemtime($files[$i])));
    }
    echo json_encode($json);
}

function explore($folder)
{
    $file = "";
    $root = scandir($folder);
    foreach ($root as $f)
    {
        if ($f == '..' || $f == '.' || $f == 'files.json' || (strpos($f, 'ignore') !== FALSE))
            continue;
        if ($f != 'thumbs' && $f != 'Thumbs.db' && $f != 'api' && $f != '.DS_Store')
        {
            if (is_file($folder . $f))
            {
                $file .= $folder . $f . ',,';
            }
            else
            {
                $suf = !is_file($folder . $f) ? "/" : "";
                $file .= explore($folder . $f . $suf);
            }
        }
    }
    return $file;
}

createJSON('content/');
?>
