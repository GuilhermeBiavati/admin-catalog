import React from 'react';
import { Navbar } from './components/Navbar';
import Box from '@material-ui/core/Box';
import { BrowserRouter } from 'react-router-dom';
import AppRouter from './routes/AppRouter';

const App: React.FC = () => {
  return (
    <React.Fragment>
      <BrowserRouter>
        <Navbar />
        <Box paddingTop="70px">
          <AppRouter />
        </Box>
      </BrowserRouter>
    </React.Fragment>
  );
};

export default App;
