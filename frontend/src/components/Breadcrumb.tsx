/* eslint-disable no-nested-ternary */
import React from 'react';
import { makeStyles, Theme, createStyles } from '@material-ui/core/styles';
import Link, { LinkProps } from '@material-ui/core/Link';
import Container from '@material-ui/core/Container';
import Box from '@material-ui/core/Box';
import Typography from '@material-ui/core/Typography';
import MuiBreadcrumbs from '@material-ui/core/Breadcrumbs';
import { Route } from 'react-router';
import { Link as RouterLink } from 'react-router-dom';
import { Location } from 'history';
import routes from '../routes';
import RouteParser from 'route-parser';

const breadcrumbNameMap: { [key: string]: string } = {};

routes.forEach(
  (route) => (breadcrumbNameMap[route.path as string] = route.label)
);

const useStyles = makeStyles((theme: Theme) =>
  createStyles({
    root: {
      display: 'flex',
      flexDirection: 'column',
    },
    item: {
      color: theme.palette.secondary.main,
      '&:focus, &:actived': {
        color: theme.palette.secondary.main,
      },
      '&:hover': {
        color: theme.palette.secondary.dark,
      },
    },
  })
);

interface LinkRouterProps extends LinkProps {
  to: string;
  replace?: boolean;
}

const LinkRouter = (props: LinkRouterProps) => (
  <Link {...props} component={RouterLink as any} />
);

export default function Breadcrumb() {
  const classes = useStyles();

  function makeBreadCrumb(location: Location) {
    const pathnames = location.pathname.split('/').filter((x) => x);

    pathnames.unshift('/');

    return (
      <MuiBreadcrumbs aria-label="breadcrumb">
        {pathnames.map((value, index) => {
          const last = index === pathnames.length - 1;
          const to = `${pathnames
            .slice(0, index + 1)
            .join('/')
            .replace('//', '/')}`;

          const route = Object.keys(breadcrumbNameMap).find((path) =>
            new RouteParser(path).match(to)
          );

          if (route === undefined) {
            return false;
          }

          return last ? (
            <Typography color="textPrimary" key={to}>
              {breadcrumbNameMap[route]}
            </Typography>
          ) : (
            <LinkRouter
              color="inherit"
              to={to}
              key={to}
              className={classes.item}
            >
              {breadcrumbNameMap[route]}
            </LinkRouter>
          );
        })}
      </MuiBreadcrumbs>
    );
  }

  return (
    <Container>
      <Box paddingTop={2} paddingBottom={1}>
        <Route>{({ location }) => makeBreadCrumb(location)}</Route>
      </Box>
    </Container>
  );
}
