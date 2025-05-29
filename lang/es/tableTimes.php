<?php

declare(strict_types=1);

return [
    'title' => 'Tabla Horarios',
    'titleClient' => 'Horarios',
    'subtitle' => 'Gestiona los horarios de las películas.',
    'subtitleClient' => '¿Cuándo quieres ir a verla?',
    'infoYouCanDo' => 'Puedes seleccionar una fecha en el calendario.',
    'columns' => [
        'id' => 'ID',
        'film_id' => 'ID de Película',
        'room_id' => 'ID de Sala',
        'time' => 'Horario',
        'created_at' => 'Creado en',
        'updated_at' => 'Actualizado en',
        'actions' => 'Acciones',
    ],
    'noTimes' => 'No hay horarios para esta película este día'
];
