import * as React from "react";
import TextField from "@material-ui/core/TextField";
import Checkbox from "@material-ui/core/Checkbox";
import Box from "@material-ui/core/Box";
import Button, { ButtonProps } from "@material-ui/core/Button";
import { FormControlLabel, makeStyles, Theme } from "@material-ui/core";
import { useForm } from "react-hook-form";
import categoryHttp from "../../util/http/category-http";
import * as yup from "../../util/vendor/yup";
import { yupResolver } from "@hookform/resolvers/yup";
import { useEffect } from "react";
import { useHistory, useParams } from "react-router-dom";
import { useState } from "react";
import { watch } from "node:fs";
import { AxiosResponse } from "axios";
import { useSnackbar } from "notistack";
import { Category } from "../../util/models";

const useStyles = makeStyles((theme: Theme) => {
  return {
    submit: {
      margin: theme.spacing(1),
    },
  };
});

const validationSchema = yup.object().shape({
  name: yup.string().label("Nome").required().max(255),
});

const Form = () => {
  const classes = useStyles();

  const {
    register,
    handleSubmit,
    getValues,
    setValue,
    reset,
    watch,
    formState: { errors },
  } = useForm({
    resolver: yupResolver(validationSchema),
  });

  const snackbar = useSnackbar();
  const history = useHistory();
  const { id } = useParams<{ id: string }>();
  const [category, setCategory] = useState<Category | null>(null);
  const [loading, setLoading] = useState<boolean>(false);

  const buttonProps: ButtonProps = {
    variant: "contained",
    size: "medium",
    className: classes.submit,
    color: "secondary",
    disabled: loading,
  };

  useEffect(() => {
    let isSubscribed = true;

    if (!id) {
      return;
    }
    async function getCategory() {
      if (isSubscribed) {
        setLoading(true);
      }
      try {
        const { data } = await categoryHttp.get(id);
        if (isSubscribed) {
          setCategory(data.data);
        }

        reset(data.data);
        return data.data;
      } catch (error) {
        console.error(error);
        snackbar.enqueueSnackbar("Não foi possivel carregar as informações", {
          variant: "error",
        });
      } finally {
        if (isSubscribed) {
          setLoading(false);
        }
      }

      getCategory();
    }

    return () => {
      isSubscribed = false;
    };
    // setLoading(true);
    // categoryHttp.get(id).then(({data}) => {
    //   // console.log(data.data);
    //   setCategory(data.data);
    //   // reset(data.data);

    // }).finally(() => setLoading(false));
  }, []);

  // const onSubmit = (formData, event) => {
  //   setLoading(true);
  //   const http = !id ? categoryHttp.create(formData) : categoryHttp.update(id, formData);
  //   http.then(({data}) => {
  //     snackbar.enqueueSnackbar('Categoria salva com sucesso', {variant: 'success'});
  //     setTimeout(() => {
  //       if(event){
  //         if(!id){
  //           history.push(`/categories/${data.data.id}/edit`)
  //         }else{
  //           history.replace(`/categories/${data.data.id}/edit`)
  //         }
  //        }else{
  //         history.push('/categories');
  //        }
  //     });
  //   }).catch((error) => {
  //     snackbar.enqueueSnackbar('Não foi possivel salvar a categoria', {variant: 'error'});

  //     console.log(error);

  //   }).finally(()=> setLoading(false));
  // };

  async function onSubmit(formData, event) {
    setLoading(true);
    try {
      const http = !id
        ? categoryHttp.create(formData)
        : categoryHttp.update(id, formData);
      const { data } = await http;
      snackbar.enqueueSnackbar("Categoria salva com sucesso", {
        variant: "success",
      });
      setTimeout(() => {
        if (event) {
          if (!id) {
            history.push(`/categories/${data.data.id}/edit`);
          } else {
            history.replace(`/categories/${data.data.id}/edit`);
          }
        } else {
          history.push("/categories");
        }
      });
    } catch (error) {
      console.error(error);
      snackbar.enqueueSnackbar("Não foi possivel salvar a categoria", {
        variant: "error",
      });
    } finally {
      setLoading(false);
    }
  }

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <TextField
        disabled={loading}
        label="Nome"
        variant={"outlined"}
        error={errors.name !== undefined}
        helperText={errors.name && errors.name.message}
        fullWidth
        {...register("name")}
      />
      <TextField
        disabled={loading}
        label="Descrição"
        multiline
        rows="4"
        fullWidth
        variant={"outlined"}
        margin={"normal"}
        {...register("description")}
      />
      <FormControlLabel
        control={
          <Checkbox
            disabled={loading}
            color="primary"
            onChange={(e) => {
              setValue("is_active", e.target.checked);
            }}
            checked={watch("is_active")}
          />
        }
        label="Ativo?"
      />

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
