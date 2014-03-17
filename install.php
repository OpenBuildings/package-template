<?php

function get_github_repo($repo_name) {
    $ch = curl_init('https://api.github.com/repos/'.$repo_name);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Clippings Package Template Script');

    return json_decode(curl_exec($ch));
}

$repo_title = ucwords(str_replace(array('-', '_'), array(' ', ' '), basename(getcwd())));
$repo_name = 'clippings/'.basename(getcwd());

$repo = get_github_repo($repo_name);

$placeholders = array(
    '%%REPO_TITLE%%' => $repo_title,
    '%%REPO_NAME%%' => $repo->full_name,
    '%%REPO_DESCRIPTION%%' => $repo->description,
    '%%REPO_NAMESPACE%%' => str_replace(' ', '', $repo_title),
    '%%AUTHOR_NAME%%' => trim(`git config --global user.name`),
    '%%AUTHOR_EMAIL%%' => trim(`git config --global user.email`),
    '%%YEAR%%' => date('Y'),
);

$allItems = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('dist'));

unlink('composer.json');
unlink('README.md');

foreach ($allItems as $file) {
    file_put_contents($file->getPathname(), strtr(file_get_contents($file->getPathname()), $placeholders));
}

$items = new FilesystemIterator('dist');

foreach ($items as $item)
{
    $newFilename = str_replace('dist/', '', $item->getPathname());
    rename($item->getPathname(), $newFilename);
}

rmdir('dist');

