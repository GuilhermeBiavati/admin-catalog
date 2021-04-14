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
  InputLabel,
  Select,
  MenuItem,
  Input,
  createStyles,
} from '@material-ui/core';
import { useForm } from 'react-hook-form';
import genreHttp from '../../util/http/genre-http';
import { Chip } from '@material-ui/core';
import { useEffect } from 'react';
import categoryHttp from '../../util/http/category-http';
import { watch } from 'node:fs';

const useStyles = makeStyles((theme: Theme) => {
  return createStyles({
    submit: {
      margin: theme.spacing(1),
    },
    formControl: {
      // margin: theme.spacing(1),
      // minWidth: 120,
      // maxWidth: 300,
    },
    chips: {
      display: 'flex',
      flexWrap: 'wrap',
    },
    chip: {
      margin: 2,
    },
    noLabel: {
      marginTop: theme.spacing(3),
    },
  });
});

const ITEM_HEIGHT = 48;
const ITEM_PADDING_TOP = 8;

const MenuProps = {
  PaperProps: {
    style: {
      maxHeight: ITEM_HEIGHT * 4.5 + ITEM_PADDING_TOP,
      width: 250,
    },
  },
};

const Form = () => {
  const classes = useStyles();

  const buttonProps: ButtonProps = {
    variant: 'outlined',
    size: 'medium',
    className: classes.submit,
  };

  const [categories, setCategories] = React.useState<any[]>([]);
  const {
    register,
    handleSubmit,
    getValues,
    setValue,
    formState: { errors },
  } = useForm();

  useEffect(() => {
    register('categories_id');
    // setValue('categories_id', []);
  }, [register]);

  const [categoriesId, setCategoriesId] = React.useState<string[]>([]);

  useEffect(() => {
    categoryHttp.list().then((response) => {
      setCategories(response.data.data);
    });
  }, []);

  const onSubmit = (data, event) => {
    console.log(data);
    genreHttp.create(data).then((response) => console.log(response.data));
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
        select
        name="categories_id"
        value={categoriesId}
        label={'Categorias'}
        margin={'normal'}
        variant={'outlined'}
        fullWidth
        onChange={(event: React.ChangeEvent<{ value: unknown }>) => {
          const value = event.target.value as string[];
          setCategoriesId(value);
          setValue('categories_id', value);
        }}
        SelectProps={{
          multiple: true,
        }}
      >
        {categories.map((category, key) => {
          return (
            <MenuItem key={key} value={category.id}>
              {category.name}
            </MenuItem>
          );
        })}
      </TextField>
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
