// Import de pacotes
import React, { useEffect, useRef, useState } from 'react';
import { Alert, Image, ImageBackground, Modal, ScrollView, StyleSheet, TouchableNativeFeedback, TouchableOpacity, TouchableWithoutFeedback, View } from 'react-native';
import { TextInputMask } from 'react-native-masked-text';
import { IconButton, RadioButton, Text, Title, TouchableRipple } from 'react-native-paper';
import { useStateLinkUnmounted } from '@hookstate/core';
import { FontAwesome5 } from '@expo/vector-icons';
import { useNavigation } from '@react-navigation/native';
import * as ImagePicker from 'expo-image-picker';

// Import de páginas
import TextInput from '../../components/Input';
import Container, { ContainerTop } from '../../components/Container';
import request from '../../util/request';
import theme from '../../global/styles/theme';
import { Button } from '../../components/Button';
import { StateUser } from '../../context/auth';
import GlobalContext from '../../context';
import { ButtonClose, ButtonSelect, ContentModal, ViewModal } from '../../components/GlobalCSS';

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';

export function AddService() {
    // Variáveis
    const [comentario, setComentario] = useState('');
    const [loading, setLoading] = useState(false);
    const [categorias, setCategorias] = useState('');
    const [subCategoria, setSubCategoria] = useState('');

    // Construção da página
    return (
        <>
            <ContainerTop>
                <ImageBackground
                    source={imgBanner}
                    style={{
                        width: '100%',
                        // height: 160,
                        justifyContent: 'center',
                        alignItems: 'center',
                    }}>
                    <Container
                        pb
                        // padding={30}
                        style={{
                            flexDirection: 'column',
                            alignItems: 'center',
                            justifyContent: 'center',
                            width: '100%',
                        }}>
                        <Image
                            source={logo}
                            resizeMode="contain"
                            style={{
                                width: 150,
                                height: 150,
                                marginTop: -30,
                                marginBottom: -55,
                            }} />
                        <TouchableOpacity
                            onPress={() => console.log('goBack()')}
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
                            RoboComp - Cadastrar Serviços
                        </Text>
                    </Container>
                </ImageBackground>
            </ContainerTop>
            <ScrollView style={styles.scrollView}>
                <Container pb />
                <Container horizontal pt>
                    <View>
                        <Text
                            style={{
                                marginBottom: 7,
                                marginRight: 10,
                                fontSize: 20,
                                fontFamily: theme.fonts.bold,
                                width: '90%',
                            }}>
                            Adicionar fotos ao serviço:
                        </Text>
                    </View>
                    {/* <Photos
                    photos={transformToPhotoArray(photos)}
                    addPhoto={uri => setPhotos([...photos, uri])}
                    removeImage={index => {
                    setPhotos(p => [...p.slice(0, index), ...p.slice(index + 1)]);
                    }}
                /> */}
                </Container>
                <Text style={styles.title}>Categoria:</Text>

                {/* Categorias cadastradas do usuário */}
                <Container>
                    <Container style={styles.radioGroup}>
                        <RadioButton.Group
                            onValueChange={newValue => {
                                console.log('NEWVALUE: ' + JSON.stringify(newValue));
                                //Mostrar a categoria selecionada
                                setCategorias(newValue);
                            }}
                            value={'categorias'}
                        >
                            {/* {(arrayCategory !== undefined) ? arrayCategory.map((arr) => ( */}
                            <TouchableOpacity /* key={arr.id} */ style={styles.radio} onPress={() => setCategorias('arr')}>
                                <RadioButton /* key={arr.id} */ value={'arr'} />
                                <View style={{ width: 30, height: 30, marginRight: 5 }}>
                                    <Image
                                        source={logo}
                                        style={{ width: 30, height: 30 }}
                                    />
                                </View>
                                <Text>arr.category_name</Text>
                            </TouchableOpacity>
                            {/* )) : <View/>} */}
                        </RadioButton.Group>
                    </Container>
                    <Text style={styles.title2}>Serviço oferecido:</Text>

                    {/* Subcategorias cadastradas para o usuário */}
                    {/* {arraySubCategory.map((arr2) => ( */}
                    {/* (arr2.category_id === categorias.categorie_id) ? //Filtra a seleção da categoria com as subcategorias */}
                    <Container style={styles.radioGroup2}>
                        <RadioButton.Group
                            onValueChange={newValue2 => { setSubCategoria(newValue2); }}
                            value={'subCategoria'}
                        >
                            <TouchableOpacity /* key={arr2.id} */ style={styles.radio2} onPress={() => setSubCategoria('arr2.name')}>
                                <RadioButton /* key={arr2.id} */ value={'arr2.name'} />
                                <Text>{'arr2.name'}</Text>
                            </TouchableOpacity>
                        </RadioButton.Group>
                    </Container>
                    {/* : */}
                    {/* <View style={{width:0, height:0}}/> */}
                    {/* ))} */}

                    {/* {(arraySubCategory.map((arr3) => (
                (arr3.name === subCategoria) ? */}
                    <>
                        <Text style={styles.title}>Preço:</Text>
                        <TextInputMask
                            //   ref={priceRef}
                            style={styles.inputMask}
                            type="money"
                            options={{
                                precision: 2,
                                separator: ',',
                                delimiter: '.',
                                unit: 'R$',
                                suffixUnit: ''
                            }}
                            value={0}
                            editable={false}
                        />
                        <Container horizontal vertical>
                            <Text>Descrição:</Text>
                            <TextInput
                                value={comentario} setValue={setComentario} />
                        </Container>
                        <Container horizontal vertical>
                            <Button
                                onPress={() => console.log('submit(arr3.price)')} //submit para funcionar
                                text="SALVAR SERVIÇO"
                                fullWidth
                                loading={loading}
                                backgroundColor={theme.colors.newcolor}
                            />
                        </Container>
                    </>
                    {/* :<View /> */}
                    {/* )))} */}
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
        backgroundColor: theme.colors.gray,
        marginHorizontal: 0,

    },
    textStyle: {
        fontSize: 20,
        fontFamily: theme.fonts.bold,
        color: 'white',
        textAlign: 'center',
    },

    textStyleF: {
        fontSize: 16,
        paddingLeft: 20,
        paddingRight: 20,
        color: 'white',
        textAlign: 'center',
        padding: 3,
    },
    title: {
        fontSize: 16,
        paddingLeft: '4%',
        paddingTop: '4%',
        marginBottom: -10
    },
    title2: {
        fontSize: 16,
        paddingLeft: '4%',
        paddingTop: '4%',
        marginBottom: 10
    },
    inputMask: {
        marginHorizontal: '3%',
    },
    inputask: {
        marginHorizontal: '3%',
        borderBottomColor: '#000',
        borderBottomWidth: 2,
    },
    radio: {
        margin: 10,
        flexDirection: 'row',
        alignItems: 'center',
        minWidth: '39%',
    },
    radioGroup: {
        width: '90%',
        margin: 15,
        flexDirection: 'row',
        flexWrap: 'wrap',
    },
    radio2: {
        marginHorizontal: 10,
        marginVertical: '-1%',
        flexDirection: 'row',
        alignItems: 'center',
        minWidth: '39%',
    },
    radioGroup2: {
        width: '70%',
        marginHorizontal: 15,
        flexDirection: 'row',
        flexWrap: 'wrap',
    },
});