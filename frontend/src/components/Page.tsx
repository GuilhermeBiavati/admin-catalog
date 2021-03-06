// @flow
import * as React from 'react';
import Typography from '@material-ui/core/Typography';
import Container from '@material-ui/core/Container';
import Box from '@material-ui/core/Box';
import { makeStyles } from '@material-ui/core';

const useStyles = makeStyles({
  title: {
    color: '#999999',
  },
});

type PageProps = {
  title: string;
};

export const Page: React.FC<PageProps> = (props) => {
  const classes = useStyles();

  return (
    <div>
      <Container>
        <Typography className={classes.title} component="h1" variant="h4">
          {props.title}
        </Typography>
        <Box paddingTop={2}>{props.children}</Box>
      </Container>
    </div>
  );
};
