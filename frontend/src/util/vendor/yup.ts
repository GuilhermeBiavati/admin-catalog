  
import {setLocale} from 'yup';

const ptBR = {
    mixed: {
         // eslint-disable-next-line
        required: '${path} é requerido',
         // eslint-disable-next-line
        notType: '${path} é inválido'
    },
    string: {
         // eslint-disable-next-line
        max: '${path} precisa ter no máximo ${max} caracteres'
    },
    number: {
         // eslint-disable-next-line
        min: '${path} precisa ser no mínimo ${min}'
    }
};

setLocale(ptBR);

export * from 'yup';