import React from 'react';

import { Chip, createMuiTheme, MuiThemeProvider } from '@material-ui/core';

import theme from '../theme';

const yesTheme = createMuiTheme({
  palette: {
    primary: theme.palette.success,
  },
});
const noTheme = createMuiTheme({
  palette: {
    primary: theme.palette.error,
  },
});

export function BadgeYes() {
  return (
    <MuiThemeProvider theme={yesTheme}>
      <Chip label="Sim" color={'primary'}></Chip>
    </MuiThemeProvider>
  );
}

export function BadgeNo() {
  return (
    <MuiThemeProvider theme={noTheme}>
      return <Chip label="Não" color={'primary'}></Chip>
    </MuiThemeProvider>
  );
}
