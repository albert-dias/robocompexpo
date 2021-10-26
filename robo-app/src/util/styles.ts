import { ScrollView } from 'react-native';
import { getBottomSpace, getStatusBarHeight } from 'react-native-iphone-x-helper';
import { RFValue, RFPercentage } from 'react-native-responsive-fontsize';
import { FontAwesome } from '@expo/vector-icons';
import styled from 'styled-components/native';

export const Container = styled(ScrollView).attrs({
  contentContainerStyle:{ paddingBottom: RFValue(100)}
})`
  flex: 1;
  padding: ${getStatusBarHeight() + RFValue(32)}px ${RFValue(24)}px ${getBottomSpace() + RFValue(10)}px;
`;

export const ContentModal = styled.View`
  background-color: rgba(0,0,0,0.5);
  flex: 1;
  justify-content: center;
  align-items: center;
  margin-top: 22px;
`;

export const ViewModal = styled.View`
  width: ${RFPercentage(35)}px;
  margin: 20px;
  background-color: white;
  border-radius: 5px;
  padding: 35px;
  align-items: center;
`;

export const ButtonClose = styled.TouchableOpacity`
  width: 40px;
  height: 40px;
  align-items: center;
  justify-content: center;
  position: absolute;
  margin-top: 5px;
  right: 0;
  margin-right: 5px;
`;

export const Title = styled.Text`
  font-family: ${({theme})=>theme.fonts.sbold};
  font-size: ${RFValue(16)}px;
  margin-top: ${RFValue(16)}px;
  text-align: center;
`;

export const ButtonSelect = styled.TouchableOpacity`
  width: 100%;
  background-color: ${({theme}) => theme.colors.inative_button};
  align-items: center;
  padding: ${RFValue(12)}px;
  border-radius: 5px;
  flex-direction: row;
  margin-top: 16px;
`;

export const Icon = styled(FontAwesome)`
  font-size: 24px;
  color: ${({theme}) => theme.colors.title};
`;

export const TextButton = styled.Text`
  color: ${({theme}) => theme.colors.title};
  font-family: ${({theme})=>theme.fonts.sbold};
  font-size: ${RFValue(18)}px;
  margin-left: 10px;
`;

export const Content = styled.View`
    flex-direction: row;
    margin-top: ${RFValue(24)}px;
`;

export const ContentImages = styled.View`
  flex-direction: row;
  flex-wrap: wrap;
  width: 100%;
  margin-bottom: ${RFValue(16)}px;
  border-radius: 5px;
  justify-content: space-evenly;
`;

export const ImageAction = styled.TouchableOpacity`
  width: 30%;
  height: ${RFValue(75)}px;
  margin-bottom: 3%;  
`;

export const ImageSelected = styled.Image`
  width: 100%;
  height: ${RFValue(75)}px;
`;

export const ContentCategories = styled.View`
    width: 100%;
    flex-direction: row;
    margin-top: ${RFValue(24)}px;
    flex-wrap: wrap;
    justify-content: space-evenly;
`;

export const Shift = styled.View`
  width: 100%;
  flex-direction: row;
  justify-content: space-between;
  margin-bottom: ${RFValue(24)}px;
`;

export const Label = styled.Text`
  margin-bottom: ${RFValue(16)}px;
  color: ${({theme})=>theme.colors.title};
`;
export const TextArea = styled.TextInput`
  border:  1px solid ${({theme})=>theme.colors.title};
  border-radius: 5px;
  padding: ${RFValue(12)}px;
  margin-bottom: ${RFValue(16)}px;
`;