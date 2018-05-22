import React from 'react';
import { ApolloProvider } from 'react-apollo';
import styled from 'styled-components';

import { client } from './client';
import { Lists } from '../Lists/Lists';


const Container = styled.div`
  padding: 1em 3em;
`

export const App = () => (
  <ApolloProvider client={client}>
    <Container>
      <h1>
        Todo List
      </h1>
      <Lists />
    </Container>
  </ApolloProvider>
)
