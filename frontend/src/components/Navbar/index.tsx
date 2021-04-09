import * as React from 'react';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
import logo from '../../static/imgs/logo.png';
import { Button, makeStyles, Theme } from '@material-ui/core';
import { Menu } from './Menu';

const useStyles = makeStyles((theme: Theme) => ({
  toolbar: {
    backgroundColor: '#000000',
  },
  title: {
    flexGrow: 1,
    textAlign: 'center',
  },
  logo: {
    width: 100,
    [theme.breakpoints.up('sm')]: {
      width: 170,
    },
  },
}));
export const Navbar: React.FC = () => {
  const classes = useStyles();

  return (
    <AppBar position="fixed" color="primary">
      <Toolbar className={classes.toolbar}>
        <Menu />
        <Typography className={classes.title}>
          <img src={logo} alt="Codeflix" className={classes.logo} />
        </Typography>
        <Button color="inherit">Login</Button>
      </Toolbar>
    </AppBar>
  );
};
