import * as React from "react";
import TextField from "@material-ui/core/TextField";
import Box from "@material-ui/core/Box";
import Button, { ButtonProps } from "@material-ui/core/Button";
import { makeStyles, Theme, MenuItem, createStyles } from "@material-ui/core";
import { useForm } from "react-hook-form";
import genreHttp from "../../util/http/genre-http";
import * as yup from "../../util/vendor/yup";
import { yupResolver } from "@hookform/resolvers/yup";
import { useSnackbar } from "notistack";
import { useHistory, useParams } from "react-router-dom";
import { useState, useEffect } from "react";
import categoryHttp from "../../util/http/category-http";
import { Category, Genre } from "../../util/models";

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
      display: "flex",
      flexWrap: "wrap",
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

const validationSchema = yup.object().shape({
  name: yup.string().label("Nome").required().max(255),
  categories_id: yup.array().label("Categorias").required(),
});

const Form = () => {
  const [categories, setCategories] = useState<Category[]>([]);
  const {
    register,
    handleSubmit,
    getValues,
    setValue,
    reset,
    formState: { errors },
  } = useForm({
    resolver: yupResolver(validationSchema),
  });

  const classes = useStyles();
  const snackbar = useSnackbar();
  const history = useHistory();
  const { id } = useParams<{ id: string }>();
  const [genre, setGenre] = useState<Genre | null>(null);
  const [loading, setLoading] = useState<boolean>(false);
  const [categoriesId, setCategoriesId] = React.useState<string[]>([]);

  const buttonProps: ButtonProps = {
    variant: "contained",
    size: "medium",
    className: classes.submit,
    color: "secondary",
    disabled: loading,
  };

  useEffect(() => {
    async function loadData() {
      setLoading(true);
      const promises = [categoryHttp.list()];
      if (id) {
        promises.push(genreHttp.get(id));
      }
      try {
        const [categoriesResponse, genreResponse] = await Promise.all(promises);
        setCategories(categoriesResponse.data.data);
        if (id) {
          setGenre(genreResponse.data.data);
          reset({
            ...genreResponse.data.data,
            categoriesId: genreResponse.data.data.categories.map(
              (category) => category.id
            ),
          });
        }
      } catch (error) {
        console.error(error);
        snackbar.enqueueSnackbar("Não foi possivel carregar as informações", {
          variant: "error",
        });
      } finally {
        setLoading(false);
      }
    }
    loadData();
  }, []);

  useEffect(() => {
    register("categories_id");
    // setValue('categories_id', []);
  }, [register]);

  async function onSubmit(formData, event) {
    setLoading(true);
    try {
      const http = !id
        ? genreHttp.create(formData)
        : genreHttp.update(id, formData);
      const { data } = await http;
      snackbar.enqueueSnackbar("Genêro salvo com sucesso", {
        variant: "success",
      });
      setTimeout(() => {
        if (event) {
          if (!id) {
            history.push(`/genres/${data.data.id}/edit`);
          } else {
            history.replace(`/genres/${data.data.id}/edit`);
          }
        } else {
          history.push("/genres");
        }
      });
    } catch (error) {
      console.error(error);
      snackbar.enqueueSnackbar("Não foi possivel salvar o genêro", {
        variant: "error",
      });
    } finally {
      setLoading(false);
    }
  }

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <TextField
        label="Nome"
        variant={"outlined"}
        fullWidth
        disabled={loading}
        error={errors.name !== undefined}
        helperText={errors.name && errors.name.message}
        {...register("name")}
      />

      <TextField
        select
        name="categories_id"
        value={categoriesId}
        label={"Categorias"}
        margin={"normal"}
        variant={"outlined"}
        fullWidth
        disabled={loading}
        error={errors.name !== undefined}
        helperText={errors.name && errors.name.message}
        onChange={(event: React.ChangeEvent<{ value: unknown }>) => {
          const value = event.target.value as string[];
          setCategoriesId(value);
          setValue("categories_id", value);
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
      <Box dir={"rtl"}>
        <Button {...buttonProps} onClick={() => onSubmit(getValues(), null)}>
          Salvar
        </Button>
        <Button {...buttonProps} type={"submit"}>
          Salvar e continuar editando
        </Button>
      </Box>
    </form>
  );
};
export default Form;
