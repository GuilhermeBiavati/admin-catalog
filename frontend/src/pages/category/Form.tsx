import * as React from 'react';
import TextField from '@material-ui/core/TextField';
import Checkbox from '@material-ui/core/Checkbox';
import Box from '@material-ui/core/Box';
import Button, { ButtonProps } from '@material-ui/core/Button';
import { FormControlLabel, makeStyles, Theme } from '@material-ui/core';
import { useForm } from 'react-hook-form';
import categoryHttp from '../../util/http/category-http';

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
    variant: 'contained',
    size: 'medium',
    className: classes.submit,
    color: 'secondary',
  };

  const {
    register,
    handleSubmit,
    getValues,
    setValue,
    formState: { errors },
  } = useForm();

  const onSubmit = (data, event) => {
    categoryHttp.create(data).then((response) => console.log(response));
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <TextField
        label="Nome"
        variant={'outlined'}
        fullWidth
        {...register('name')}
      />
      <TextField
        {...register('description')}
        label="Descrição"
        multiline
        rows="4"
        fullWidth
        variant={'outlined'}
        margin={'normal'}
      />
      <FormControlLabel
        control={
          <Checkbox
            color="primary"
            onChange={(e) => {
              setValue('is_active', e.target.checked);
            }}
            defaultChecked
          />
        }
        label="Ativo?"
      />

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
