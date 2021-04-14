import * as React from 'react';
import TextField from '@material-ui/core/TextField';
import Checkbox from '@material-ui/core/Checkbox';
import Box from '@material-ui/core/Box';
import Button, { ButtonProps } from '@material-ui/core/Button';
import {
  FormControlLabel,
  makeStyles,
  Theme,
  RadioGroup,
  FormLabel,
  FormControl,
  Radio,
} from '@material-ui/core';
import { useForm } from 'react-hook-form';
import memberHttp from '../../util/http/member-http';

const useStyles = makeStyles((theme: Theme) => {
  return {
    submit: {
      margin: theme.spacing(1),
    },
  };
});

const Form = () => {
  const classes = useStyles();

  const buttonProps: ButtonProps = {
    variant: 'outlined',
    size: 'medium',
    className: classes.submit,
  };

  const {
    register,
    handleSubmit,
    getValues,
    formState: { errors },
  } = useForm();

  const onSubmit = (data, event) => {
    memberHttp.create(data).then((response) => console.log(response));
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <TextField
        label="Nome"
        variant={'outlined'}
        fullWidth
        {...register('name')}
      />

      <FormControl>
        <FormLabel>
          <RadioGroup {...register('type')}>
            <FormControlLabel value="1" control={<Radio />} label={'Diretor'} />
            <FormControlLabel value="2" control={<Radio />} label={'Ator'} />
          </RadioGroup>
        </FormLabel>
      </FormControl>

      <Box dir={'rtl'}>
        <Button {...buttonProps} onClick={() => onSubmit(getValues(), null)}>
          Salvar
        </Button>
        <Button {...buttonProps} type={'submit'}>
          Salvar e continuar editando
        </Button>
      </Box>
    </form>
  );
};
export default Form;
