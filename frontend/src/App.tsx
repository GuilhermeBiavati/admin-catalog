import React from 'react';
import { Navbar } from './components/Navbar';
import Box from '@material-ui/core/Box';
import { CssBaseline, MuiThemeProvider } from '@material-ui/core';
import { BrowserRouter } from 'react-router-dom';
import AppRouter from './routes/AppRouter';
import Breadcrumb from './components/Breadcrumb';
import theme from './theme';

const App: React.FC = () => {
  return (
    <React.Fragment>
      <MuiThemeProvider theme={theme}>
        <CssBaseline />
        <BrowserRouter>
          <Navbar />
          <Box paddingTop="70px">
            <Breadcrumb />
            <AppRouter />
          </Box>
        </BrowserRouter>
      </MuiThemeProvider>
    </React.Fragment>
  );
};

export default App;
