// Import de pacotes
import styled from 'styled-components/native';
import { View } from 'react-native';
import { Text, TextInput } from 'react-native-paper';

export const Container = styled.View`
`;

export const BottomNav = styled(View)`
    height: 70px;
    background-color: ${({ theme }) => theme.colors.surface};
    flex-direction: row;
    align-items: center;
    width: 100%;
    justify-content: center;
`;