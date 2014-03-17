<?php

function get_github_repo($repo_name) {
    $ch = curl_init('https://api.github.com/repos/'.$repo_name);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Clippings Package Template Script');

    return json_decode(curl_exec($ch));
}

$repo_name = 'clippings/'.basename(getcwd());

$repo = get_github_repo($repo_name);

$placeholders = array(
    '%%REPO_NAME%%' => $repo->full_name,
    '%%REPO_DESCRIPTION%%' => $repo->description,
    '%%REPO_NAMESPACE%%' => str_replace(' ', '', ucwords(str_replace(array('-', '_'), array(' ', ' '), $repo_name))),
    '%%AUTHOR_NAME%%' => `git config --global user.name`,
    '%%AUTHOR_EMAIL%%' => `git config --global user.email`,
    '%%YEAR%%' => date('Y'),
);

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('dist'));

unlink('composer.json');

foreach ($files as $file) {
    file_put_contents($file->getPathname(), strtr(file_get_contents($file->getPathname()), $placeholders));
    rename($file->getPathname(), str_replace('dist/', '', $file->getPathname()));
}

rmdir('dist');

