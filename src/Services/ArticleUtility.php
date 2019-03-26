<?php
    namespace App\Services;
    use App\Entity\Article;

    class ArticleUtility
    {
        public function Slug(string $string): string
        {
            return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
        }

        public function toUrl(Article $article): string
        {
            $aRemplacer 	= [
                /* VOYELLES */
                'à','â','ä',		/* A */
                'é','è','ê','ë',	/* E */
                'ï','î',			/* I */
                'ö','ô',			/* O */
                'ü','û','ù',		/* U */
    
                /* CONSONNES */
                'ç',				/* ç */
    
                /* CARACTERES SPECIAUX */
                '&',				/* & */
                '#',				/* # */
                '{',				/* { */
                '}',				/* } */
                '(',				/* ( */
                ')',				/* ) */
                '[',				/* [ */
                ']',				/* ] */
                '|',				/* | */
                '\\',				/* \ */
                '+',				/* + */
                '-',				/* - */
                '/',				/* / */
                '*',				/* * */
                '%',				/* % */
    
                /* ESPACES */
                ' ',				/*  */
    
                /* PONCTUATIONS */
                ':',				/* : */
                ',',				/* , */
                ';',				/* ; */
                '?',				/* ? */
                '"',				/* " */
                '\'',				/* ' */
                '!'					/* ! */
            ];

            $remplacement	= [
                /* VOYELLES */
                'a','a','a',		/* A */
                'e','e','e','e',	/* E */
                'i','i',			/* I */
                'o','o',			/* O */
                'u','u','u',		/* U */
    
                /* CONSONNES */
                'c',				/* ç */
    
                /* CARACTERES SPECIAUX */
                '-',				/* & */
                '',					/* # */
                '',					/* { */
                '',					/* } */
                '',					/* ( */
                '',					/* ) */
                '',					/* [ */
                '',					/* ] */
                '',					/* | */
                '',					/* \ */
                '+',				/* + */
                '-',				/* - */
                '',					/* / */
                '',					/* * */
                '',					/* % */
    
                /* ESPACES */
                '-',				/*  */
    
                /* PONCTUATIONS */
                '-',				/* : */
                '-',				/* , */
                '-',				/* ; */
                '-',				/* ? */
                '-',				/* " */
                '-',				/* ' */
                '',					/* ! */
            ];
    
            return ucwords(strtolower(str_replace($aRemplacer, $remplacement, $article->getTitle())));
        }
    }
    