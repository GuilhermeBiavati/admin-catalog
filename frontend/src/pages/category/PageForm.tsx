import { Page } from '../../components/Page';
import Form from './Form';
import * as React from 'react';
import { useParams } from 'react-router-dom';

const PageForm = () => {
  const {id} = useParams<{ id: string }>();

  return (
    <Page title={!id ? "Criar categoria": "Editar Categoria"}>
      <Form />
    </Page>
  );
};

export default PageForm;
