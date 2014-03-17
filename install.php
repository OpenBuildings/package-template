<?php

$repo_name = dirname(getcwd());

$repo = json_decode(file_get_contents('https://api.github.com/repos/'.$repo_name));

$placeholders = array(
    '%%REPO_NAME%%' => $dir->full_name,
    '%%REPO_DESCRIPTION%%' => $repo->description,
    '%%REPO_NAMESPACE%%' => str_replace(' ', '', ucwords(str_replace(array('-', '_'), array(' ', ' '), $repo_name))),
    '%%AUTHOR_NAME%%' => `git config --global user.name`,
    '%%AUTHOR_EMAIL%%' => `git config --global user.email`,
    '%%YEAR%%' => date('Y'),
);

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('dist'));

unlink('composer.json');

foreach($files as $file) {
    if ($file->isFile()) {
        var_dump($item->getFilename());
        // file_put_contents($item->getFilename(), strtr(file_get_contents('../test/bootstrap.php'), $placeholders));
    }
}

