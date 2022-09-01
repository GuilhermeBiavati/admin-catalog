// @flow
import * as React from "react";
import Typography from "@material-ui/core/Typography";
import Container from "@material-ui/core/Container";
import { Box, Button, Theme } from "@material-ui/core";
import { makeStyles } from "@material-ui/core";
import { ButtonProps } from "@material-ui/core/Button";

const useStyles = makeStyles((theme: Theme) => {
  return {
    submit: {
      margin: theme.spacing(1),
    },
  };
});

interface SubmitActionsProps {
  disableButtons?: boolean;
  handleSave: () => void;
}

export const SubmitActions: React.FC<SubmitActionsProps> = (props) => {
  const classes = useStyles();

  const buttonProps: ButtonProps = {
    variant: "contained",
    size: "medium",
    className: classes.submit,
    color: "secondary",
    disabled: props.disableButtons ?? false,
  };

  return (
    <Box dir={"rtl"}>
      <Button {...buttonProps} onClick={props.handleSave}>
        Salvar
      </Button>
      <Button {...buttonProps} type={"submit"}>
        Salvar e continuar editando
      </Button>
    </Box>
  );
};
