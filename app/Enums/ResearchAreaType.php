<?php

namespace App\Enums;

enum ResearchAreaType: string
{
    case CHIMICA = 'chimica';
    case STORIA = 'storia';
    case MATEMATICA = 'matematica';
    case INFORMATICA = 'informatica';
    case SOCIOLOGIA = 'sociologia';
    case PSICOLOGIA = 'psicologia';
    case MEDICINA = 'medicina';


    public function description(): string
    {
        return match($this) {
            self::CHIMICA => 'Studio della composizione, della struttura e delle proprietà della materia, nonché delle trasformazioni che essa subisce.',
            self::STORIA => 'Analisi critica degli eventi del passato, delle società umane e dei processi evolutivi politici, economici e culturali.',
            self::MATEMATICA => 'Scienza formale che studia i numeri, le strutture, lo spazio e il cambiamento attraverso il ragionamento logico e deduttivo.',
            self::INFORMATICA => 'Scienza e tecnologia dell\'elaborazione automatica delle informazioni, dei sistemi di calcolo e dello sviluppo software.',
            self::SOCIOLOGIA => 'Studio scientifico dei fenomeni sociali, dei gruppi, delle organizzazioni e dei comportamenti collettivi.',
            self::PSICOLOGIA => 'Studio scientifico della mente, dei processi cognitivi, affettivi e dei comportamenti umani.',
            self::MEDICINA => 'Scienza biomedica dedicata alla prevenzione, alla diagnosi, alla cura delle malattie e al benessere psicofisico della persona.',
        };
    }

}


