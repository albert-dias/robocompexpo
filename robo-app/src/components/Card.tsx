import {Card, Text, TouchableRipple} from 'react-native-paper';
import styled from 'styled-components/native';
import theme from '../global/styles/theme';
import {View} from 'react-native';
import React from 'react';

export const StyledCardContent = styled(Card.Content)``;
export const StyledCardCover = styled(Card.Cover)`
  border-top-left-radius: 3px;
  border-top-right-radius: 3px;
`;

export const StyledCardTitle = styled(Text)`
  color: ${theme.colors.black};
  font-size: 20px;
  text-align: center;
  font-weight: 900;
  margin-bottom: 10px;
`;

export const StyledCardTitleTop = styled(Text)`
  color: ${theme.colors.white};
  font-size: 26px;
  text-align: center;
  font-weight: 900;
  margin-bottom: 10px;
`;

interface CardLeftProps {
  color?: string;
}

export const CardLeft = styled(View).attrs((p: CardLeftProps) => p)`
  background-color: ${p => p.color || theme.colors.surface};
  justify-content: center;
  align-items: center;
  border-top-left-radius: 3px;
  border-bottom-left-radius: 3px;
  flex-grow: 0;
`;
export const Car = styled(View)`
  background-color: ${theme.colors.background};
  justify-content: center;
  align-items: center;
  border-top-left-radius: 5px;
  border-bottom-left-radius: 5px;
  flex-grow: 0;
`;

export const CardContent = styled(View)`
  flex-grow: 1;
  flex-shrink: 1;
  width: 100%;
  align-items: center;
  justify-content: flex-start;
`;

export const CardContentList = styled(View)`
  flex-grow: 1;
  flex-shrink: 1;
  width: 100%;
  justify-content: flex-start;
  align-items: center;
`;

const CardComponentWrapper = styled(View)`
  width: 100%;
  flex-direction: row;
  border-radius: 3px;
  justify-content: flex-start;
`;

export const CardComponentTop = styled(View)`
  width: 100%;
  height: 90px;
  background-color: ${theme.colors.orange};
  margin-bottom: 0px;
  flex-direction: row;
  border-radius: 0px;
  justify-content: flex-start;
`;

const CardComponent: React.FC<React.ComponentProps<typeof TouchableRipple>> = ({
  children,
  ...props
}) => (
  <TouchableRipple
    {...props}
    style={{
      backgroundColor: theme.colors.white,
      borderRadius: 20,
    }}>
    <CardComponentWrapper>{children}</CardComponentWrapper>
  </TouchableRipple>
);

export default CardComponent;
