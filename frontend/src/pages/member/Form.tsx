import * as React from "react";
import TextField from "@material-ui/core/TextField";
import Box from "@material-ui/core/Box";
import Button, { ButtonProps } from "@material-ui/core/Button";
import {
  FormControlLabel,
  makeStyles,
  Theme,
  RadioGroup,
  FormLabel,
  FormControl,
  Radio,
  FormHelperText,
} from "@material-ui/core";
import { useForm } from "react-hook-form";
import memberHttp from "../../util/http/member-http";
import * as yup from "../../util/vendor/yup";
import { yupResolver } from "@hookform/resolvers/yup";
import { useSnackbar } from "notistack";
import { useHistory, useParams } from "react-router-dom";
import { useState, useEffect } from "react";
import { CastMember } from "../../util/models";

const useStyles = makeStyles((theme: Theme) => {
  return {
    submit: {
      margin: theme.spacing(1),
    },
  };
});

const validationSchema = yup.object().shape({
  name: yup.string().label("Nome").required().max(255),
  type: yup.number().label("Tipo").required(),
});

const Form = () => {
  const classes = useStyles();

  const {
    register,
    handleSubmit,
    getValues,
    reset,
    formState: { errors },
  } = useForm({
    resolver: yupResolver(validationSchema),
  });

  const snackbar = useSnackbar();
  const history = useHistory();
  const { id } = useParams<{ id: string }>();
  const [menbers, setMenber] = useState<CastMember | null>(null);
  const [loading, setLoading] = useState<boolean>(false);

  const buttonProps: ButtonProps = {
    variant: "contained",
    size: "medium",
    className: classes.submit,
    color: "secondary",
    disabled: loading,
  };

  useEffect(() => {
    if (!id) {
      return;
    }
    async function getMenbers() {
      setLoading(true);
      try {
        const { data } = await memberHttp.get(id);
        setMenber(data.data);

        reset(data.data);
        return data.data;
      } catch (error) {
        console.error(error);
        snackbar.enqueueSnackbar("Não foi possivel carregar as informações", {
          variant: "error",
        });
      } finally {
        setLoading(false);
      }

      getMenbers();
    }
  }, []);

  async function onSubmit(formData, event) {
    setLoading(true);
    try {
      const http = !id
        ? memberHttp.create(formData)
        : memberHttp.update(id, formData);
      const { data } = await http;
      snackbar.enqueueSnackbar("Menbro de elenco salvo com sucesso", {
        variant: "success",
      });
      setTimeout(() => {
        if (event) {
          if (!id) {
            history.push(`/menbers/${data.data.id}/edit`);
          } else {
            history.replace(`/menbers/${data.data.id}/edit`);
          }
        } else {
          history.push("/menbers");
        }
      });
    } catch (error) {
      console.error(error);
      snackbar.enqueueSnackbar("Não foi possivel salvar o menbro de elenco", {
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

      <FormControl error={errors.type !== undefined} disabled={loading}>
        <FormLabel>
          <RadioGroup {...register("type")}>
            <FormControlLabel
              value="1"
              control={<Radio color="primary" />}
              label={"Diretor"}
            />
            <FormControlLabel
              value="2"
              control={<Radio color="primary" />}
              label={"Ator"}
            />
          </RadioGroup>
        </FormLabel>
        {errors.type ? (
          <FormHelperText id="type-helper-text">
            {errors.type.message}
          </FormHelperText>
        ) : null}
      </FormControl>

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
