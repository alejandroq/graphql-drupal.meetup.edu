import { ApolloClient } from 'apollo-client';
import { HttpLink } from 'apollo-link-http';
import { InMemoryCache } from 'apollo-cache-inmemory';

export const client = new ApolloClient({
  link: new HttpLink({ uri: 'http://headlessdrupal.lndo.site:8000/graphql' }),
  cache: new InMemoryCache(),
  connectToDevTools: true,
});