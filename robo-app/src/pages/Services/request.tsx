// Import de pacotes
import React, { useEffect, useState } from 'react';
import {
    Alert, Image, ImageBackground, ScrollView, StyleSheet,
    TouchableNativeFeedback, TouchableOpacity, View,
} from 'react-native';
import { IconButton, Text, TouchableRipple } from 'react-native-paper';
import { FontAwesome5 } from '@expo/vector-icons';
import { LinearGradient } from 'expo-linear-gradient';

// Import de páginas
import TextInput from '../../components/Input';
import Container, { ContainerTop } from '../../components/Container';
import request from '../../util/request';
import theme from '../../global/styles/theme';
// import GlobalContext from '../../context';

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';

// const {
//     cadastro: {
//         categoryIdsRef
//     },
//     category: {
//         categoriesRef, fetchCategories
//     }
// } = GlobalContext;

interface PhotoProps {
    photos: string[][];
    addPhoto: (uri: string) => void;
    removeImage: (index: number) => void;
}

const Photos: React.FC<PhotoProps> = ({ photos, addPhoto, removeImage }) => (
    <Container horizontal>
        <View style={{ flexDirection: 'column' }}>
            {/* {photos.map((i, indexI) => (
                <View
                    key={indexI}
                    style={{
                        width: '100%',
                        flexDirection: 'row',
                        marginLeft: 10,
                        paddingRight: 10,
                        paddingTop: 10,
                    }}>
                    {i.map((j, indexJ) =>
                        j === 'new-photo' ? (
                            <View
                                key={indexJ}
                                style={{
                                    width: '50%',
                                    paddingRight: 10,
                                    paddingBottom: 10,
                                }}>
                                <TouchableRipple
                                    style={{
                                        width: '100%',
                                        height: 100,
                                        borderRadius: 5,
                                        borderColor: theme.colors.black,
                                        borderWidth: 1,
                                    }}
                                    onPress={() => {
                                        pickImage(addPhoto);
                                    }}>
                                    <View>
                                        <IconButton
                                            icon='image-plus'
                                            style={{
                                                width: '100%',
                                                height: '100%',
                                                marginLeft: 0,
                                                marginTop: -11,
                                            }}
                                            size={30}
                                            color={theme.colors.black}
                                        />
                                        <Text
                                            style={{
                                                width: '100%',
                                                textAlign: 'center',
                                                fontSize: 15,
                                                position: 'absolute',
                                                top: 60,
                                            }}>
                                            Adicionar foto
                                        </Text>
                                    </View>
                                </TouchableRipple>
                            </View>
                        ) : (<View
                            key={indexJ}
                            style={{
                                width: '50%',
                                overflow: 'hidden',
                                paddingRight: 10,
                            }}>
                            <TouchableNativeFeedback
                                // background={TouchableNativeFeedback.Ripple(theme.colors.whitepure)}
                                background={TouchableNativeFeedback.Ripple('#FFF', true)}
                                onPress={() => {
                                    Alert.alert(
                                        'AVISO!',
                                        `Deseja remover a imagem ${indexJ + 1}`,
                                        [
                                            {
                                                text: 'Remover',
                                                onPress: () => {
                                                    console.log('removeImage(indexJ);');
                                                },
                                                style: 'cancel',
                                            },
                                            {
                                                text: 'Cancelar',
                                            },
                                        ],
                                    );
                                }}
                                useForeground
                                style={{
                                    width: '100%',
                                    height: '100%',
                                }}>
                                <View>
                                    <Image
                                        key={indexJ}
                                        source={{
                                            uri: j,
                                        }}
                                        style={{
                                            width: '100%',
                                            height: 100,
                                            borderRadius: 5,
                                        }}
                                    />
                                </View>
                            </TouchableNativeFeedback>
                        </View>)
                    )}
                </View>
            ))} */}
        </View>
    </Container>
);

export function Request() {
    const [photos, setPhotos] = useState<string[]>([]);
    const [loading, setLoading] = useState(false);
    const [description, setDescription] = useState('');

    return (
        <>
            <ContainerTop>
                <ImageBackground
                    source={imgBanner}
                    style={{
                        width: '100%',
                        justifyContent: 'center',
                        alignItems: 'center',
                    }}>
                    <Container pb
                        style={{
                            flexDirection: 'column',
                            alignItems: 'center',
                            justifyContent: 'center',
                            width: '100%',
                        }}>
                        <Image
                            source={logo}
                            resizeMode='contain'
                            style={{
                                width: 150,
                                height: 150,
                                marginTop: -30,
                                marginBottom: -55,
                            }} />
                        <TouchableOpacity
                            onPress={() => console.log('navigate(Home)')}
                            style={{
                                position: 'absolute',
                                alignSelf: 'flex-start',
                                marginLeft: '5%',
                                alignContent: 'flex-start',
                                alignItems: 'flex-start',
                            }}>
                            <FontAwesome5
                                name='chevron-left'
                                color={theme.colors.white}
                                size={40}
                            />
                        </TouchableOpacity>
                        <Text style={styles.textStyleF}>
                            RoboComp - Solicitar Serviço
                        </Text>
                    </Container>
                </ImageBackground>
            </ContainerTop>
            <ScrollView style={styles.scrollView}>
                <Container horizontal vertical>
                    <View>
                        <Text style={styles.titleText}>
                            Adicione fotos do serviço a ser feito:
                        </Text>
                        {/* <Photos
                            photos={transformToPhotoArray}
                        /> */}
                    </View>
                    <View>
                        <Text style={styles.titleText}>Descrição do serviço:</Text>
                        <TextInput
                            value={description}
                            setValue={setDescription}
                        />
                        <TouchableOpacity
                            onPress={() => console.log('submit')}
                        >
                            <View style={styles.makeOrder}>
                                <LinearGradient
                                    style={styles.touchButtonContainer}
                                    colors={theme.colors.gradientInvert}
                                    start={{ x: 0.0, y: 1.0 }}
                                    end={{ x: 1.0, y: 1.0 }}
                                >
                                    <Text style={{ color: '#fff', fontSize: 16 }}>Fazer Pedido</Text>
                                </LinearGradient>
                            </View>
                        </TouchableOpacity>
                    </View>
                </Container>
            </ScrollView>
        </>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
    },
    scrollView: {
        backgroundColor: '#F4F1F0',
        marginHorizontal: 0,
    },
    textStyleF: {
        fontSize: 16,
        paddingLeft: 20,
        paddingRight: 20,
        color: 'white',
        textAlign: 'center',
        padding: 3,
    },
    nview: {
        width: '100%',
        justifyContent: 'center',
        alignItems: 'center',
    },
    checkboxContainer: {
        flexDirection: "row",
        marginBottom: 20,
        alignItems: 'center',
    },
    makeOrder: {
        flex: 1,
        flexDirection: "row",
        width: '100%',
        justifyContent: 'space-around',
        paddingTop: 20
    },
    touchButtonContainer: {
        alignItems: 'center',
        justifyContent: 'center',
        width: '35%',
        borderRadius: 30,
        padding: 10,
    },
    dataColetaContainer: {
        flex: 1,
        justifyContent: 'center',
        alignItems: 'center',
    },
    dataColetaSectionStyle: {
        flexDirection: 'row',
        justifyContent: 'center',
        alignItems: 'center',
        backgroundColor: '#fff',
    },
    dataColetaImageStyle: {
        padding: 10,
        margin: 5,
        height: 25,
        width: 25,
        resizeMode: 'stretch',
        alignItems: 'center',
        justifyContent: 'center'
    },
    buttonBack: {
        position: 'relative',
        alignSelf: 'flex-start',
        marginLeft: '10%',
        marginTop: '15%',
        alignContent: 'flex-start',
        alignItems: 'flex-start',
    },
    titleText: {
        marginVertical: 10,
        marginRight: 10,
        marginHorizontal: 0,
        fontSize: 20,
        fontFamily: theme.fonts.bold,
        width: '90%',
        alignSelf: 'center',
    },
});