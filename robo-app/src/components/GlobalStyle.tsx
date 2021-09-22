import styled from 'styled-components';
import { LinearGradient } from 'expo-linear-gradient';
import React from 'react';
import theme from '../global/styles/theme';

const GlobalStyleBase = styled(LinearGradient)`
  height: 100%;
`;

const GlobalStyle: React.FC = ({ children }) => (
  <GlobalStyleBase colors={theme.colors.gradient}>
    {children}
  </GlobalStyleBase>
);


export default GlobalStyle;