<?php

namespace App;

enum QuestionType: string
{
        //['text', 'textarea', 'radio', 'checkbox', 'select', 'email', 'number', 'date', 'time']);

    case TEXT = 'text';
    case RADIO = 'radio';
    case CHECKBOX = 'checkbox';
    case TEXTAREA = 'textarea';
    case SELECT = 'select';
    case EMAIL = 'email';
    case NUMBER = 'number';
    case DATE = 'date';
    case TIME = 'time';


    public function getHtmlPreview(): string
    {
        return match ($this) {
            self::RADIO => '<input type="radio" disabled />',
            self::CHECKBOX => '<input type="checkbox" disabled />',
            self::TEXT => '<input type="text" disabled value="Sample Text" />',
            self::TEXTAREA => '<textarea disabled rows="1" style="resize: none;">Sample Text</textarea>',
            self::SELECT => '<select disabled><option>Select</option></select>',
            self::EMAIL => '<input type="email" disabled value="example@example.com" />',
            self::NUMBER => '<input type="number" disabled value="0" />',
            self::DATE => '<input type="date" disabled />',
            self::TIME => '<input type="time" disabled />',
        };
    }
}
