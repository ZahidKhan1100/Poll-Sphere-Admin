<?php

namespace App;

enum QuestionType: string
{
    case TEXT = 'text';
    case RADIO = 'radio';
    case CHECKBOX = 'checkbox';
    case TEXTAREA = 'textarea';
    case SELECT = 'select';
    case EMAIL = 'email';
    case NUMBER = 'number';
    case DATE = 'date';
    case TIME = 'time';
}
