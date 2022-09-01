import React from "react";
import { Navbar } from "./components/Navbar";
import Box from "@material-ui/core/Box";
import { CssBaseline, MuiThemeProvider } from "@material-ui/core";
import { BrowserRouter } from "react-router-dom";
import AppRouter from "./routes/AppRouter";
import Breadcrumb from "./components/Breadcrumb";
import theme from "./theme";
import { SnackbarProvider } from "./components/SnackbarProvider";
import { ReactKeycloakProvider } from "@react-keycloak/web";
import { keycloak } from "./util/auth";

const App: React.FC = () => {
  return (
    <ReactKeycloakProvider authClient={keycloak}>
      <MuiThemeProvider theme={theme}>
        <SnackbarProvider>
          <CssBaseline />
          <BrowserRouter>
            <Navbar />
            <Box paddingTop="70px">
              <Breadcrumb />
              <AppRouter />
            </Box>
          </BrowserRouter>
        </SnackbarProvider>
      </MuiThemeProvider>
    </ReactKeycloakProvider>
  );
};

export default App;
