<?php

mkdir('_posts/centros/guarderias/filtros/localidades', 0777, true);
mkdir('_posts/centros/guarderias/filtros/provincias', 0777, true);
mkdir('_posts/centros/guarderias/centros', 0777, true);

$row = 0;
$provinceList = [];
$locationList = [];
$locationJS = [];
$provinceJS = [];
$t[7] = ['name' => 0, 'slug' => 7, 'provinceList' => [8 => ['name' => 1, 'slug' => '8']]];
$type = [];
$type2 = [];
if (($handle = fopen("centros.tsv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 2048, "\t")) !== FALSE) {
        $row++;
        if($row === 1) {
            continue;
        }

//        $locationJS[$data[7]] = [
//            'name' => $data[0],
//            'slug' => $data[7],
//        ];

        $locationJS[$data[7]]['name'] = $data[0];
        $locationJS[$data[7]]['slug'] = $data[7];
        $locationJS[$data[7]]['provinceList'][$data[8]]['name'] = $data[1];
        $locationJS[$data[7]]['provinceList'][$data[8]]['slug'] = $data[8];

//        $provinceJS[$data[7]][$data[8]] = [
//            'name' => $data[1],
//            'slug' => $data[8],
//        ];

//        $locationJS[$data[7]]['provinceList'][$data[8]] = [
//            'name' => $data[1],
//            'slug' => $data[8],
//        ];

        $provinceList[$data[7]] = [
            'name' => $data[0],
            'slug' => $data[7],
        ];

        $locationList[$data[7] . '-' . $data[8]] = [
            'province' => $data[7],
            'name' => $data[1],
            'slug' => $data[8],
        ];

        if (empty($type[$data[2]])) {
            $type[$data[2]] = 0;
        } else {
            $type[$data[2]]++;
        }

        createGuarderia($data);

//        if ($row == 500) {
//            break;
//        }
    }
    fclose($handle);
}


//ksort($locationJS);
//file_put_contents('provinceList.json', json_encode($locationJS));
//
////echo json_encode($provinceJS);
//die();

//var_dump($location);
//var_dump($type);
//var_dump($type2);
//echo $row;

foreach ($provinceList as $province) {
//    createProvince($province);
}

foreach ($locationList as $location) {
//    createLocation($location);
}


foreach ($type as $key => $t) {
//    file_put_contents('type.txt', $key . "\n", FILE_APPEND);
}

function getTypeCenter($type)
{
    $guarderia = [
//        'Colegio de Educación Infantil y Primaria',
//        'Centro Privado de Educación Infantil Primaria y Secundaria',
//        'Centro Privado de Educación Infantil y Primaria',
//        'Centro Privado de Educación Infantil y Secundaria',
//        'Centro Privado de Educación Infantil, Primaria y ESO',
//        'Colegio de Educación Infantil, Primaria y Secundaria',
//        'Colegio de Educación Infantil Primaria y Primer Ciclo de ESO',
//        'Colexio de Educación Infantil e Primaria',
//        'Escuela de Educación Infantil, Casa de Niños',
//        'Centro Privado de Educación Infantil, Primaria, Secundaria y Educación Especial',
//        'Centro Privado Concertado de Educación Infantil, Primaria, Secundaria y Educación Especial',
//        'Centro Público de Educación Infantil y Básica',
//        'Colegio Público de Educación Infantil y Primaria/Haur eta Lehen Hezkuntzako Ikastetxe Publikoa',
//        'Centro Privado de Educación Infantil de Primer Ciclo',
//        'Colegio de Educación Infantil y Primaria',
//        'Colegio de Educación Infantil y Primaria',
//        'Colegio de Educación Infantil y Primaria',
        'Centro Privado de Educación Infantil',
        'Escuela Infantil',
    ];

    if (array_search($type, $guarderia) !== false) {
        return 'guarderia';
    }

    return 'fake';
}

function createGuarderia(array $data)
{
    if (getTypeCenter($data[2]) !== 'guarderia') {
        return;
    }

//    if($data[1] != 'Torrejon de Ardoz') {
//        return;
//    }

    $fileName = '_posts/centros/guarderias/centros/2017-09-21-' . $data[4] . '.md';
    if(file_exists($fileName)) {
        unlink($fileName);
    }
    $title = ucwords(str_replace('"', "", $data[3]));
    $permalink = '/guarderias/' . $data[6] . '.html';
    file_put_contents($fileName, '---' . "\n", FILE_APPEND);
    file_put_contents($fileName, 'layout: post' . "\n", FILE_APPEND);
    file_put_contents($fileName, 'title: "' . $data[2] . " " . $title . "\"\n", FILE_APPEND);
    file_put_contents($fileName, 'date: 2017-09-20 20:57:05 +0200' . "\n", FILE_APPEND);
    file_put_contents($fileName, 'categories:' . "\n", FILE_APPEND);
    file_put_contents($fileName, "" . '- ' . $data[2] . "\n", FILE_APPEND);
    file_put_contents($fileName, "" . '- ' . $data[7] . "\n", FILE_APPEND);
    file_put_contents($fileName, "" . '- ' . $data[8] . "\n", FILE_APPEND);
    file_put_contents($fileName, "" . '- ' . $data[5] . "\n", FILE_APPEND);
    file_put_contents($fileName, "" . '- guarderia' . "\n", FILE_APPEND);
    file_put_contents($fileName, 'name: "' . $title . "\"\n", FILE_APPEND);
    file_put_contents($fileName, 'province: "' . $data[0] . "\"\n", FILE_APPEND);
    file_put_contents($fileName, 'location: "' . $data[1] . "\"\n", FILE_APPEND);
    file_put_contents($fileName, 'code: "' . $data[4] . "\"\n", FILE_APPEND);
    file_put_contents($fileName, 'type: "' . $data[5] . "\"\n", FILE_APPEND);
    file_put_contents($fileName, 'img: guarderia.jpg' . "\n", FILE_APPEND);
    file_put_contents($fileName, 'permalink: ' . $permalink . "\n", FILE_APPEND);
    file_put_contents($fileName, '---' . "\n", FILE_APPEND);

    $province = [
        'name' => $data[0],
        'slug' => $data[7],
    ];

    $location = [
        'province' => $data[7],
        'name' => $data[1],
        'slug' => $data[8],
    ];

    createProvince($province);
    createLocation($location);
}

function createProvince(array $province)
{
    $fileName = '_posts/centros/guarderias/filtros/provincias/2017-09-21-' . $province['slug'] . '.md';
    if(file_exists($fileName)) {
        unlink($fileName);
    }
    $title = ucwords(str_replace('"', "", $province['name']));
    $permalink = '/guarderias-en-' . $province['slug'] . '/';
    file_put_contents($fileName, '---' . "\n", FILE_APPEND);
    file_put_contents($fileName, 'layout: location' . "\n", FILE_APPEND);
    file_put_contents($fileName, 'title: "Guarderías en ' . $title . "\"\n", FILE_APPEND);
    file_put_contents($fileName, 'date: 2017-09-20 20:57:05 +0200' . "\n", FILE_APPEND);
    file_put_contents($fileName, 'categories:' . "\n", FILE_APPEND);
    file_put_contents($fileName, "" . '- provincia' . "\n", FILE_APPEND);
    file_put_contents($fileName, "" . '- ' . $province['slug'] . "\n", FILE_APPEND);
    file_put_contents($fileName, 'name: "' . $title . "\"\n", FILE_APPEND);
    file_put_contents($fileName, 'slug: "' . $province['slug'] . "\"\n", FILE_APPEND);
    file_put_contents($fileName, 'permalink: ' . $permalink . "\n", FILE_APPEND);
    file_put_contents($fileName, '---' . "\n", FILE_APPEND);
}

function createLocation(array $location)
{
//    if($location['name'] != 'Torrejon de Ardoz') {
//        return;
//    }

    $fileName = '_posts/centros/guarderias/filtros/localidades/2017-09-21-' . $location['slug'] . '.md';
    if(file_exists($fileName)) {
        unlink($fileName);
    }
    $title = ucwords(str_replace('"', "", $location['name']));
    $permalink = '/guarderias-en-' . $location['slug'] . '/';
    file_put_contents($fileName, '---' . "\n", FILE_APPEND);
    file_put_contents($fileName, 'layout: centre' . "\n", FILE_APPEND);
    file_put_contents($fileName, 'title: "Guarderías en ' . $title . "\"\n", FILE_APPEND);
    file_put_contents($fileName, 'date: 2017-09-20 20:57:05 +0200' . "\n", FILE_APPEND);
    file_put_contents($fileName, 'categories:' . "\n", FILE_APPEND);
    file_put_contents($fileName, "" . '- localidad' . "\n", FILE_APPEND);
    file_put_contents($fileName, "" . '- ' . $location['slug'] . "\n", FILE_APPEND);
    file_put_contents($fileName, "" . '- ' . $location['province'] . "\n", FILE_APPEND);
    file_put_contents($fileName, 'name: "' . $title . "\"\n", FILE_APPEND);
    file_put_contents($fileName, 'slug: "' . $location['slug'] . "\"\n", FILE_APPEND);
    file_put_contents($fileName, 'slug-province: "' . $location['province'] . "\"\n", FILE_APPEND);
    file_put_contents($fileName, 'permalink: ' . $permalink . "\n", FILE_APPEND);
    file_put_contents($fileName, '---' . "\n", FILE_APPEND);
}

/**
 * file_put_contents($fileName, '---' . "\n", FILE_APPEND);
 * file_put_contents($fileName, 'layout: post' . "\n", FILE_APPEND);
 * file_put_contents($fileName, 'position: 1' . "\n", FILE_APPEND);
 * file_put_contents($fileName, 'title: "' . ucwords(mb_strtolower($book->getName())) . "\"\n", FILE_APPEND);
 * file_put_contents($fileName, 'best_seller: no' . "\n", FILE_APPEND);
 * file_put_contents($fileName, 'price: ' . $book->getPrice() . ' €' . "\n", FILE_APPEND);
 * file_put_contents($fileName, 'writer: "' . $book->getAuthor() . "\"\n", FILE_APPEND);
 * file_put_contents($fileName, 'count_page: ' . $book->getNumberPage() . "\n", FILE_APPEND);
 * file_put_contents($fileName, 'isbn: ' . $book->getId() . "\n", FILE_APPEND);
 * file_put_contents($fileName, 'language: Español' . "\n", FILE_APPEND);
 * file_put_contents($fileName, 'publish: "' . $book->getDate() . "\"\n", FILE_APPEND);
 * file_put_contents($fileName, 'img: ' . $this->_generateImg($book) . "\n", FILE_APPEND);
 * file_put_contents($fileName, 'referrer: ' . $book->getDetailUrl() . "\n", FILE_APPEND);
 * file_put_contents($fileName, 'date: "' . $this->_getPublishDate() . "\"\n", FILE_APPEND);
 * file_put_contents($fileName, 'categories: ' . $this->_getCategory($book) . "\n", FILE_APPEND);
 * file_put_contents($fileName, 'category: ' . $this->_getCategory($book) . "\n", FILE_APPEND);
 * file_put_contents($fileName, 'permalink: ' . $this->_getPermalink($book) . "\n", FILE_APPEND);
 * file_put_contents($fileName, 'sitemap: false' . "\n", FILE_APPEND);
 * file_put_contents($fileName, 'meta-description: "' . mb_substr($book->getReview(), 0, 200) . "\"\n", FILE_APPEND);
 * file_put_contents($fileName, 'index: noindex' . "\n", FILE_APPEND);
 * file_put_contents($fileName, '---' . "\n", FILE_APPEND);
 * file_put_contents($fileName, '## Reseña del editor' . "\n", FILE_APPEND);
 * file_put_contents($fileName, $book->getReview() . "\n", FILE_APPEND);
 */